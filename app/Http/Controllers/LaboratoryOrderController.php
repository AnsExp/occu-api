<?php
namespace App\Http\Controllers;

use App\Http\Filters\LaboratoryOrderFilter;
use App\Http\Requests\LaboratoryOrderRequest;
use App\Http\Requests\LaboratoryOrderResultRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LaboratoryOrder;
use App\Http\Services\LaboratoryOrderService;
use App\Http\Resources\LaboratoryOrderResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaboratoryOrderController extends Controller
{
    public function __construct(private LaboratoryOrderService $laboratoryOrderService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LaboratoryOrderFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([LaboratoryOrderResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Laboratory orders retrieved successfully' : 'No laboratory orders found'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(LaboratoryOrder $laboratoryOrder)
    {
        return ApiResponse::data(
            LaboratoryOrderResource::make($laboratoryOrder),
            true,
            'Laboratory order retrieved successfully',
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function pdf(LaboratoryOrder $laboratoryOrder)
    {
        $pdf = Pdf::loadView('documents.laboratory_order', compact('laboratoryOrder'));
        return $pdf->stream($laboratoryOrder->code . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryOrderRequest $request)
    {
        $laboratoryOrder = $this->laboratoryOrderService->store($request);
        return ApiResponse::data(LaboratoryOrderResource::make($laboratoryOrder), true, 'Laboratory order created successfully', 201);
    }

    /**
     * Store the result of a laboratory order in storage.
     */
    public function storeResult(LaboratoryOrder $laboratoryOrder, LaboratoryOrderResultRequest $request)
    {
        $laboratoryOrderUpdated = $this->laboratoryOrderService->result($request, $laboratoryOrder);
        return ApiResponse::data(LaboratoryOrderResource::make($laboratoryOrderUpdated), true, 'Laboratory order result stored successfully', 201);
    }

    /**
     * Display the specified resource document.
     */
    public function showResult(LaboratoryOrder $laboratoryOrder, $idDocument)
    {
        $document = $laboratoryOrder->documents()->find($idDocument);
        if (!$document || !$document->file || !occu_storage()->exists($document->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($document->file));
    }

    /**
     * Display the specified resource document.
     */
    public function zipResult(LaboratoryOrder $laboratoryOrder)
    {
        $documents = $laboratoryOrder->documents;

        $zip = new \ZipArchive();
        $zipPath = occu_storage()->path('temp/' . date('Y-m-d_H-i-s') . '.zip');


        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {

            foreach ($documents as $document) {

                if ($document->file && occu_storage()->exists($document->file)) {

                    $zip->addFile(occu_storage()->path($document->file), basename($document->file));

                }

            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryOrder $laboratoryOrder, LaboratoryOrderRequest $request)
    {
        $laboratoryOrder = $this->laboratoryOrderService->update($request, $laboratoryOrder);
        return ApiResponse::data(LaboratoryOrderResource::make($laboratoryOrder), true, 'Laboratory order updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaboratoryOrder $laboratoryOrder)
    {
        $laboratoryOrder->delete();
        return ApiResponse::data(null, true, 'Laboratory order deleted successfully', 200);
    }
}
