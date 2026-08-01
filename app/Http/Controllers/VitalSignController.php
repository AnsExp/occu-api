<?php

namespace App\Http\Controllers;

use App\Http\Requests\VitalSignRequest;
use App\Http\Services\VitalSignService;
use App\Models\MedicalDate;
use App\Models\Specialty;
use App\Models\VitalSign;

class VitalSignController extends Controller
{
    public function __construct(private VitalSignService $vitalSignService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Specialty $specialty, MedicalDate $medicalDate)
    {
        if ($medicalDate->vital_signs_id) {
            abort(403, 'Ya se han tomado los signos vitales para está cita médica');
        }
        $specialty = $medicalDate->doctor->specialty;
        return view('vital_signs.create', compact('medicalDate', 'specialty'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VitalSignRequest $request)
    {
        if (!hash_equals($request->session()->token(), $request->input('_token', ''))) {
            abort(419, 'Token CSRF inválido');
        }

        $medicalDate = MedicalDate::find($request->input('medical_date.id'));
        $specialty = Specialty::find($request->input('specialty.id'));

        if ($medicalDate?->vital_signs_id) {
            abort(403, 'Ya se han tomado los signos vitales para está cita médica');
        }

        $this->vitalSignService->store($request);
        return redirect()->route('dashboard.index', [$specialty, $medicalDate]);
    }

    /**
     * Display the specified resource.
     */
    public function show(VitalSign $vitalSign)
    {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VitalSign $vitalSign)
    {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VitalSignRequest $request, VitalSign $vitalSign)
    {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VitalSign $vitalSign)
    {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }
}
