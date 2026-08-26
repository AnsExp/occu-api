<?php
namespace App\Http\Controllers\Api;

use App\Http\Filters\LaboratoryOrderFilter;
use App\Http\Requests\LaboratoryOrderRequest;
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
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return LaboratoryOrderResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryOrderRequest $request)
    {
        $laboratoryOrder = $this->laboratoryOrderService->store($request);
        return LaboratoryOrderResource::make($laboratoryOrder);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaboratoryOrder $laboratoryOrder)
    {
        return LaboratoryOrderResource::make($laboratoryOrder);
    }

    /**
     * Display the specified resource file.
     */
    public function file(LaboratoryOrder $laboratoryOrder)
    {
        $pdf = Pdf::loadView('documents.laboratory_order', ['order' => $laboratoryOrder])->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        return $pdf->stream();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryOrderRequest $request, LaboratoryOrder $laboratoryOrder)
    {
        $laboratoryOrder = $this->laboratoryOrderService->update($request, $laboratoryOrder);
        return LaboratoryOrderResource::make($laboratoryOrder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaboratoryOrder $laboratoryOrder)
    {
        $laboratoryOrder->delete();
        return response()->json(['message' => 'Laboratory order deleted successfully']);
    }
}
