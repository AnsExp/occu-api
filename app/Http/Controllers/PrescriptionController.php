<?php

namespace App\Http\Controllers;

use App\Http\Filters\PrescriptionFilter;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Prescription;
use App\Http\Services\PrescriptionService;
use App\Http\Resources\PrescriptionResource;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function show(Prescription $prescription)
    {
        return ApiResponse::data(PrescriptionResource::make($prescription), true, 'Prescription retrieved successfully', 200);
    }

    /**
     * Display the specified resource file.
     */
    public function pdf(Prescription $prescription)
    {
         $pdf = Pdf::loadView('documents.prescription', compact('prescription'));
        return $pdf->stream($prescription->code . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Prescription $prescription, PrescriptionRequest $request)
    {
        $prescription = $this->prescriptionService->update($request, $prescription);
        return ApiResponse::data(PrescriptionResource::make($prescription), true, 'Prescription updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return ApiResponse::data(null, true, 'Prescription deleted successfully.', 200);
    }
}
