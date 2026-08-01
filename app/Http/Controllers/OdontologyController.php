<?php

namespace App\Http\Controllers;

use App\Http\Requests\OdontologyRequest;
use App\Http\Services\OdontologyService;
use App\Models\Certificate;
use App\Models\MedicalDate;

class OdontologyController extends Controller
{
    public function __construct(private OdontologyService $odontologyService)
    {
        $this->authorizeResource(Certificate::class, 'certificate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OdontologyRequest $request)
    {
        $certificate = $this->odontologyService->store($request);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate, $certificate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OdontologyRequest $request, Certificate $odontology)
    {
        $certificate = $this->odontologyService->update($request, $odontology);
        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = $medicalDate->specialty;
        return redirect()->route('dashboard.show', [$specialty, $medicalDate, $certificate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $odontology)
    {
        return abort(403, 'Acceso denegado. Comuníquese con el area de sistemas.');
    }
}
