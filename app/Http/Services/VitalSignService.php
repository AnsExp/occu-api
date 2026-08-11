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
                'medical_date_id' => $medicalDate->id,
                'weight' => $request->input('weight'),
                'height' => $request->input('height'),
                'blood_pressure_systolic' => $request->input('blood_pressure_systolic'),
                'blood_pressure_diastolic' => $request->input('blood_pressure_diastolic'),
                'temperature' => $request->input('temperature'),
                'oxygen_saturation' => $request->input('oxygen_saturation'),
            ]);

            return $vitalSigns;
        });
    }

    public function update(Request $request, VitalSign $vitalSign)
    {
        return DB::transaction(function () use ($request, $vitalSign) {
            return null;
        });
    }
}
