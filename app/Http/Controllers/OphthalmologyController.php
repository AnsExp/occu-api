<?php

namespace App\Http\Controllers;

use App\Http\Requests\OphthalmologyRequest;
use App\Http\Services\OphthalmologyService;
use App\Models\Certificate;
use App\Models\MedicalDate;

class OphthalmologyController extends Controller
{
    public function __construct(private OphthalmologyService $ophthalmologyService)
    {
        $this->authorizeResource(Certificate::class, 'certificate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OphthalmologyRequest $request)
    {
        $this->ophthalmologyService->store($request);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OphthalmologyRequest $request, Certificate $ophthalmology)
    {
        $certificate = $this->ophthalmologyService->update($request, $ophthalmology);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate, $certificate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $ophthalmology)
    {
        abort(403, 'Acceso denegado. Comuníquese con el area de sistemas.');
    }
}
