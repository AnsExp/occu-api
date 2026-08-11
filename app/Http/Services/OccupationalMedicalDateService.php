<?php

namespace App\Http\Services;

use App\Models\MedicalDateRelationship;
use App\Models\MedicalDate;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationalMedicalDateService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = Person::find($request->input('person.id'));
            $patient = PatientService::preparePerson($person);
            $occupationalDate = MedicalDate::create([
                'code' => MedicalDate::generateCode(),
                'timezone' => $request->input('timezone'),
                'order' => $this->currentOrder($request->input('doctor.id'), $request->input('date')),
                'patient_id' => $patient->id,
                'date' => $request->input('date'),
                'doctor_id' => $request->input('doctor.id'),
                'type' => 'occupational',
            ]);

            foreach ($request->input('medical_dates', []) as $index => $medicalDate) {

                $medicalDate = MedicalDate::create([
                    'code' => MedicalDate::generateCode(),
                    'timezone' => $request->input('timezone'),
                    'order' => $this->currentOrder($medicalDate['doctor']['id'], $medicalDate['date']),
                    'patient_id' => $patient->id,
                    'date' => $medicalDate['date'],
                    'doctor_id' => $medicalDate['doctor']['id'],
                    'specialty_id' => $medicalDate['specialty']['id'],
                ]);

                MedicalDateRelationship::create([
                    'related_id' => $medicalDate->id,
                    'principal_id' => $occupationalDate->id,
                ]);

            }

            return $occupationalDate;
        });
    }

    private function currentOrder(int $doctorId, string $date): int
    {
        $lastOrder = MedicalDate::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->orderByDesc('order')
            ->first();

        return $lastOrder ? $lastOrder->order + 1 : 1;
    }

    public function update(Request $request, MedicalDate $medicalDate)
    {
        return DB::transaction(function () use ($request, $medicalDate) {
            return null;
        });
    }
}
