<?php
namespace App\Http\Controllers;

use App\Http\Filters\LaboratoryOrderFilter;
use App\Http\Requests\LaboratoryOrderRequest;
use App\Models\LaboratoryOrder;
use App\Http\Services\LaboratoryOrderService;
use App\Http\Resources\LaboratoryOrderResource;
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
        return LaboratoryOrderResource::collection($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaboratoryOrder $laboratoryOrder)
    {
        return response()->json(LaboratoryOrderResource::make($laboratoryOrder), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryOrderRequest $request)
    {
        $laboratoryOrder = $this->laboratoryOrderService->store($request);
        return response()->json(LaboratoryOrderResource::make($laboratoryOrder), 201);
    }

    /**
     * Display the specified resource file.
     */
    public function file(LaboratoryOrder $laboratoryOrder)
    {
        $document = $laboratoryOrder->latestDocument;
        $storage = occu_storage();

        if (!$document || !$storage->exists($document->file)) {
            return response()->json([
                'message' => 'Document not found for this laboratory order.'
            ], 404);
        }

        return response()->file($storage->path($document->file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryOrderRequest $request, LaboratoryOrder $laboratoryOrder)
    {
        $laboratoryOrder = $this->laboratoryOrderService->update($request, $laboratoryOrder);
        return response()->json(LaboratoryOrderResource::make($laboratoryOrder), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaboratoryOrder $laboratoryOrder)
    {
        $laboratoryOrder->delete();
        return response()->json(['message' => 'Laboratory order deleted successfully.'], 200);
    }
}
