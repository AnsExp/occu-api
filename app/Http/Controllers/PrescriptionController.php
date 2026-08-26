<?php

namespace App\Http\Controllers;

use App\Http\Filters\PrescriptionFilter;
use App\Http\Requests\PrescriptionRequest;
use App\Models\Prescription;
use App\Http\Services\PrescriptionService;
use App\Http\Resources\PrescriptionResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
     * Display the specified resource file.
     */
    public function file(Prescription $prescription)
    {
        $pdf = Pdf::loadView('documents.prescription', compact('prescription'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        return $pdf->stream();
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
