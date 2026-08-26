<?php

namespace App\Http\Controllers;

use App\Http\Filters\PatientFilter;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Http\Services\PatientService;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private PatientService $patientService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PatientFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request)->paginate($perPage);
        return PatientResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $patient = $this->patientService->store($request);
        return PatientResource::make($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return PatientResource::make($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient = $this->patientService->update($request, $patient);
        return PatientResource::make($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
