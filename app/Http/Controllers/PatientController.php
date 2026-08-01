<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Services\PatientService;
use App\Models\Patient;
use App\Policies\PatientPolicy;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService,
        private PatientPolicy $policy
    ) {
        $this->authorizeResource(Patient::class, 'patient');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Patient::paginate(10);
        return view('patients.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        // return response()->json($request->all());
        $patient = $this->patientService->store($request);
        return redirect()->route('patients.show', $patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateRequest $request, Patient $patient)
    {
        // return response()->json($request->validated());
        $patient = $this->patientService->update($request, $patient);
        return redirect()->route('patients.show', $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        abort(403, 'Unauthorized action.');
    }
}
