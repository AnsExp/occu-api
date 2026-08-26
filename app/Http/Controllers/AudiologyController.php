<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudiologyRequest;
use App\Http\Services\AudiologyService;
use App\Models\Document;
use App\Models\MedicalDate;

class AudiologyController extends Controller
{
    public function __construct(private AudiologyService $audiologyService)
    {
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
    public function update(AudiologyRequest $request, Document $audiology)
    {
        // $this->audiologyService->update($request, $audiology);
        // $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        // $specialty = $medicalDate->specialty;
        // return redirect()->route('dashboard.show', [$specialty, $medicalDate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $audiology)
    {
        $audiology->delete();
        abort(403, 'Acceso denegado. Comuníquese con el area de sistemas.');
    }
}
