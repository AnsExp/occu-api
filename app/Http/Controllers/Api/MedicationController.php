<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\MedicationService;
use App\Models\Medication;
use App\Http\Requests\MedicationRequest;
use App\Http\Resources\MedicationResource;
use App\Http\Filters\MedicationFilter;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function __construct(private MedicationService $medicationService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicationFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request)->paginate($perPage);
        return MedicationResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicationRequest $request)
    {
        $medication = $this->medicationService->store($request);
        return MedicationResource::make($medication);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medication $medication)
    {
        return MedicationResource::make($medication);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicationRequest $request, Medication $medication)
    {
        $medication = $this->medicationService->store($request);
        return MedicationResource::make($medication);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();
        return response()->noContent();
    }
}
