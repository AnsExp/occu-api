<?php

namespace App\Http\Services;

use App\Models\OccupationalMedicalDate;
use App\Models\MedicalDate;
use App\Models\Person;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationalMedicalDateService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $person = Person::find($request->input('person.id'));
            $patient = PatientService::preparePerson($person);
            $master = (int) $request->input('master_medical_date', -1);
            $groupMedicalDate = OccupationalMedicalDate::create([
                'code' => OccupationalMedicalDate::generateCode(),
                'patient_id' => $patient->id,
                'occupational_doctor_id' => $request->input('occupational_doctor.id'),
            ]);
            foreach ($request->input('medical_dates', []) as $index => $medicalDate) {
                $specialty = Specialty::find($medicalDate['specialty']['id']);
                $medicalDate = MedicalDate::create([
                    'code' => MedicalDate::generateCode(),
                    'timezone' => $request->input('timezone'),
                    'order' => 1,
                    'patient_id' => $patient->id,
                    'price' => $specialty->price_base,
                    'date' => $medicalDate['date'],
                    'doctor_id' => $medicalDate['doctor']['id'],
                    'specialty_id' => $medicalDate['specialty']['id'],
                    'occupational_medical_date_id' => $groupMedicalDate->id,
                ]);
                if ($index === $master) {
                    $groupMedicalDate->medical_date_master_id = $medicalDate->id;
                    $groupMedicalDate->save();
                }
            }
            return $groupMedicalDate;
        });
    }

    public function update(Request $request, MedicalDate $medicalDate)
    {
        return DB::transaction(function () use ($request, $medicalDate) {
            return null;
        });
    }
}
