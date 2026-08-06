<?php

namespace App\Http\Controllers\Api;

use App\Http\Filters\PrescriptionFilter;
use App\Http\Requests\PrescriptionRequest;
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
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return PrescriptionResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        $prescription = $this->prescriptionService->store($request);
        return PrescriptionResource::make($prescription);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        return PrescriptionResource::make($prescription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $prescription = $this->prescriptionService->update($request, $prescription);
        return PrescriptionResource::make($prescription);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return response()->json(['message' => 'Prescription deleted successfully']);
    }
}
