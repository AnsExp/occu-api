<?php

namespace App\Http\Services;

use App\Models\Person;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = Person::find($request->input('person.id'));
            $patient = PatientService::preparePerson($person);

            $prescription = Prescription::create([
                'code' => $this->generateCode(),
                'patient_id' => $patient->id,
                'notes' => $request->input('notes'),
                'timezone' => $request->input('timezone'),
            ]);

            foreach ($request->input('medications', []) as $medication) {
                $prescription->medications()->create([
                    'medication_id' => $medication['id'],
                    'notes' => $medication['notes'],
                ]);
            }

            return $prescription;
        });
    }

    public function update(Request $request, Prescription $prescription)
    {
        return DB::transaction(function () use ($request, $prescription) {
            return null;
        });
    }

    private function generateCode()
    {
        $offset = 0;
        do {
            $offset++;
            $lastOrder = Prescription::withTrashed(true)->latest('id')->first();
            $code = 'FAR-' . Date('Ymd') . '-' . (($lastOrder?->id ?? 0) + 1 + $offset);
        } while (Prescription::withTrashed(true)->where('code', $code)->exists());
        return $code;
    }
}
