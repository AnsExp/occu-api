<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CertificateType;
use App\Models\Order;
use App\Models\Patient;
use App\Policies\OrderPolicy;
use App\Services\OrderCreationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class OrderController extends Controller
{
    private OrderPolicy $policy;
    private OrderCreationService $orderCreationService;

    public function __construct()
    {
        $this->policy = new OrderPolicy();
        $this->orderCreationService = new OrderCreationService();
    }

    public function index()
    {
        if (!$this->policy->viewAny(request()->user())) {
            abort(403, 'No tienes permiso para acceder a las órdenes de pago.');
        }
        $filters = [
            'id_card' => request('id_card', null),
            'order_number' => request('order_number', null),
            'start_date' => request('start_date', null),
            'end_date' => request('end_date', null),
        ];

        // Query base
        $query = Order::with(['patient', 'details']);

        // Filtro por cédula del paciente
        if ($filters['id_card']) {
            $query->whereHas('patient', function ($q) use ($filters) {
                $q->where('id_card', 'like', "%{$filters['id_card']}%");
            });
        }

        // Filtro por número de orden
        if ($filters['order_number']) {
            $query->where('order_number', 'like', "%{$filters['order_number']}%");
        }

        // Filtro por rango de fechas
        if ($filters['start_date'] && $filters['end_date']) {
            // Ambas fechas (between inclusive)
            $query->whereDate('created_at', '>=', $filters['start_date'])
                ->whereDate('created_at', '<=', $filters['end_date']);
        } elseif ($filters['start_date']) {
            // Solo desde
            $query->whereDate('created_at', '>=', $filters['start_date']);
        } elseif ($filters['end_date']) {
            // Solo hasta
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        // Ejecutar query con paginación
        $ordersPaginated = $query->orderByDesc('created_at')
            ->paginate(get_setting('pagination_per_page', 10))
            ->withQueryString();

        return view('pages.orders', ['filters' => $filters, 'orders' => $ordersPaginated]);
    }

    public function create()
    {
        if (!$this->policy->create(request()->user())) {
            abort(403, 'No tienes permiso para crear órdenes de pago.');
        }
        $idCard = request('id_card', null);
        $patient = null;
        if ($idCard) {
            $patient = Patient::with('metadata')->where('id_card', '=', $idCard)->first();
            if ($patient) {
                $patient->date_of_birth = $patient->date_of_birth?->format('Y-m-d');
            }
        }
        return view('forms.orders', ['patient' => $patient]);
    }

    public function edit(Order $order)
    {
        // This method is not implemented as per the provided routes and views. If needed, it can be implemented similarly to the create method, but loading the existing order data for editing.
    }

    public function store(Request $request)
    {
        if (!$this->policy->create(request()->user())) {
            abort(403, 'No tienes permiso para crear órdenes de pago.');
        }

        $order = $this->orderCreationService->createFromRequest($request);

        return redirect()->intended(route('orders.pdf', ['order' => $order->order_number]));
    }

    public function show(Order $order)
    {
        if (!$this->policy->view(request()->user(), $order)) {
            abort(403, 'No tienes permiso para visualizar la orden de pago.');
        }

        $order->load(['details', 'patient.metadata']);

        $pdf = PDF::loadView('documents.order', ['order' => $order]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="order-' . $order->order_number . '.pdf"');
    }

    public function pdf(Order $order)
    {
        if (!$this->policy->view(request()->user(), $order)) {
            abort(403, 'No tienes permiso para visualizar todos los documentos asociados a la orden.');
        }

        $order->load(['details', 'patient.metadata']);

        $documents = [];

        $orderPdf = PDF::loadView('documents.order', ['order' => $order]);
        $orderPdf->setPaper('A4', 'portrait');
        $orderPdf->render();
        $documents[] = $orderPdf->output();

        $certificates = $order->certificates()
            ->orderBy('created_at')
            ->get();

        foreach ($certificates as $certificate) {
            $certificatePdf = $this->buildCertificatePdf($certificate);
            if ($certificatePdf !== null) {
                $documents[] = $certificatePdf;
            }
        }

        $mergedPdf = $this->mergePdfDocuments($documents);

        return response($mergedPdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="order-' . $order->order_number . '.pdf"');
    }

    private function buildCertificatePdf(Certificate $certificate): ?string
    {
        $view = match ($certificate->type) {
            CertificateType::AUDIOLOGY => 'documents.audiology',
            CertificateType::OPHTHALMOLOGY => 'documents.ophthalmology',
            CertificateType::OCCUPATIONAL => 'documents.occupational',
            default => null,
        };

        if ($view === null) {
            return null;
        }

        $certificate->loadMissing(['doctor', 'order']);

        $pdf = PDF::loadView($view, ['certificate' => $certificate]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf->output();
    }

    private function mergePdfDocuments(array $pdfDocuments): string
    {
        $fpdiClass = '\\setasign\\Fpdi\\Fpdi';
        $streamReaderClass = '\\setasign\\Fpdi\\PdfParser\\StreamReader';

        if (!class_exists($fpdiClass) || !class_exists($streamReaderClass)) {
            throw new \RuntimeException('FPDI library is not available.');
        }

        $fpdi = new $fpdiClass();

        foreach ($pdfDocuments as $pdfContent) {
            $pageCount = $fpdi->setSourceFile($streamReaderClass::createByString($pdfContent));

            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $templateId = $fpdi->importPage($pageNumber);
                $size = $fpdi->getTemplateSize($templateId);
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';

                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }
        }

        return $fpdi->Output('S');
    }
}
