<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudiologyRequest;
use App\Http\Services\AudiologyService;
use App\Models\Certificate;
use App\Models\MedicalDate;

class AudiologyController extends Controller
{
    public function __construct(private AudiologyService $audiologyService)
    {
        $this->authorizeResource(Certificate::class, 'certificate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AudiologyRequest $request)
    {
        $this->audiologyService->store($request);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AudiologyRequest $request, Certificate $audiology)
    {
        $this->audiologyService->update($request, $audiology);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $audiology)
    {
        abort(403, 'Acceso denegado. Comuníquese con el area de sistemas.');
    }
}
