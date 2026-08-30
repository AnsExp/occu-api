<?php

namespace App\Http\Controllers;

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
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return PrescriptionResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        $prescription = $this->prescriptionService->store($request);
        return response()->json(PrescriptionResource::make($prescription), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        return response()->json(PrescriptionResource::make($prescription), 200);
    }

    /**
     * Display the specified resource file.
     */
    public function file(Prescription $prescription)
    {
        $document = $prescription->document;
        $storage = occu_storage();

        if (!$document || !$storage->exists($document->file)) {
            return response()->json([
                'message' => 'Document not found for this prescription.'
            ], 404);
        }

        return response()->file($storage->path($document->file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $prescription = $this->prescriptionService->update($request, $prescription);
        return response()->json(PrescriptionResource::make($prescription), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return response()->json(['message' => 'Prescription deleted successfully'], 200);
    }
}
