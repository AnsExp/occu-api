<?php

namespace App\Http\Services;

use App\Models\Agreement;
use App\Models\MedicalDate;
use App\Models\VitalSign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VitalSignService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $medicalDate = MedicalDate::find($request->input('medical_date.id'));

            $vitalSigns = VitalSign::create([
                'patient_id' => $medicalDate->patient_id,
                'emo' => $request->input('emo'),
                'pulse' => $request->input('pulse'),
                'weight' => $request->input('weight'),
                'height' => $request->input('height'),
                'glucose' => $request->input('glucose'),
                'protein' => $request->input('protein'),
                'blood_type' => $request->input('blood_type'),
                'blood_pressure_systolic' => $request->input('blood_pressure_systolic'),
                'blood_pressure_diastolic' => $request->input('blood_pressure_diastolic'),
            ]);

            // $medicalDate->vital_signs_id = $vitalSigns->id;
            $medicalDate->vitalSigns()->associate($vitalSigns);
            $medicalDate->save();

            return $vitalSigns;
        });
    }

    public function update(Request $request, Agreement $agreement)
    {
        return DB::transaction(function () use ($request, $agreement) {
            return null;
        });
    }
}
