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
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return PatientResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $patient = $this->patientService->store($request);
        return response()->json(PatientResource::make($patient), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return response()->json(PatientResource::make($patient), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient = $this->patientService->update($request, $patient);
        return response()->json(PatientResource::make($patient), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully.'], 200);
    }
}
