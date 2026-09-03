<?php

namespace App\Http\Controllers;

use App\Http\Filters\PrescriptionFilter;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Prescription;
use App\Http\Services\PrescriptionService;
use App\Http\Resources\PrescriptionResource;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function __construct(private PrescriptionService $prescriptionService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PrescriptionFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([PrescriptionResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Prescriptions retrieved successfully' : 'No prescriptions found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        $prescription = $this->prescriptionService->store($request);
        return ApiResponse::data(PrescriptionResource::make($prescription), true, 'Prescription created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return ApiResponse::data(null, false, 'Prescription not found', 404);
        }
        return ApiResponse::data(PrescriptionResource::make($prescription), true, 'Prescription retrieved successfully', 200);
    }

    /**
     * Display the specified resource file.
     */
    public function document($id, $idDocument)
    {
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return ApiResponse::data(null, false, 'Prescription not found', 404);
        }
        $document = $prescription->documents()->find($idDocument);
        if (!$document || !$document->file || !occu_storage()->exists($document->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($document->file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, $id)
    {
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return ApiResponse::data(null, false, 'Prescription not found', 404);
        }
        $prescription = $this->prescriptionService->update($request, $prescription);
        return ApiResponse::data(PrescriptionResource::make($prescription), true, 'Prescription updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return ApiResponse::data(null, false, 'Prescription not found', 404);
        }
        $prescription->delete();
        return ApiResponse::message(null, true, 'Prescription deleted successfully.', 200);
    }
}
