<?php
namespace App\Http\Controllers;

use App\Http\Filters\LaboratoryOrderFilter;
use App\Http\Requests\LaboratoryOrderRequest;
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
    public function show(int $id)
    {
        $laboratoryOrder = LaboratoryOrder::find($id);
        if (!$laboratoryOrder) {
            return ApiResponse::formResponse(['Laboratory order not found'], false, 'Laboratory order not found', 404);
        }
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
    public function pdf(int $id)
    {
        $laboratoryOrder = LaboratoryOrder::find($id);
        if (!$laboratoryOrder) {
            return ApiResponse::formResponse(['Laboratory order not found'], false, 'Laboratory order not found', 404);
        }
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
     * Display the specified resource document.
     */
    public function document($id, $idDocument)
    {
        $laboratoryOrder = LaboratoryOrder::find($id);
        if (!$laboratoryOrder) {
            return response()->json([
                'message' => 'Laboratory order not found.'
            ], 404);
        }
        $document = $laboratoryOrder->documents()->find($idDocument);
        if (!$document || !$document->file || !occu_storage()->exists($document->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($document->file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryOrderRequest $request, LaboratoryOrder $laboratoryOrder)
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
