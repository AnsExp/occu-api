<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\MedicalDate;
use App\Models\MedicalDateRelationship;
use App\Models\PersonalData;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalDateService
{
    public function __construct(private MetadataService $metadataService)
    {
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = PersonalData::findByIdCard($request->input('person.id_card'));
            $doctor = Doctor::find($request->input('doctor.id'));
            $patient = PatientService::preparePatient($person);

            $specialty = null;
            if ($request->has('specialty.id')) {
                $specialty = Specialty::find($request->input('specialty.id'));
            }

            $medicalDate = MedicalDate::create([
                'code' => MedicalDate::generateCode(),
                'timezone' => $request->input('timezone'),
                'date' => $request->input('date'),
                'type' => $request->input('type', 'normal'),
                'shift' => $this->generateOrder($request->input('date'), $doctor),
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'specialty_id' => $specialty?->id,
            ]);

            foreach ($request->input('relationship', []) as $relationship) {

                $relatedPerson = PersonalData::findByIdCard($relationship['person']['id_card']);
                $relatedPatient = PatientService::preparePatient($relatedPerson);
                $relatedDoctor = Doctor::find($relationship['doctor']['id']);
                $relatedSpecialty = Specialty::find($relationship['specialty']['id']);

                $related = MedicalDate::create([
                    'code' => MedicalDate::generateCode(),
                    'timezone' => $request->input('timezone'),
                    'date' => $relationship['date'],
                    'type' => $relationship['type'] ?? 'normal',
                    'shift' => $this->generateOrder($relationship['date'], $relatedDoctor),
                    'doctor_id' => $relatedDoctor->id,
                    'patient_id' => $relatedPatient->id,
                    'specialty_id' => $relatedSpecialty?->id,
                ]);

                MedicalDateRelationship::create([
                    'principal_id' => $medicalDate->id,
                    'related_id' => $related->id,
                ]);
            }

            return $medicalDate;
        });
    }

    public function update(Request $request, MedicalDate $medicalDate)
    {
        return DB::transaction(function () use ($request, $medicalDate) {

            $person = PersonalData::findByIdCard($request->input('person.id_card'));
            $doctor = Doctor::find($request->input('doctor.id'));
            $specialty = Specialty::find($request->input('specialty.id'));

            $patient = PatientService::preparePatient($person);

            $medicalDate->update([
                'timezone' => $request->input('timezone'),
                'date' => $request->input('date'),
                'type' => $request->input('type', 'normal'),
                'shift' => $this->generateOrder($request->input('date'), $doctor),
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'specialty_id' => $specialty?->id,
            ]);

            $this->metadataService->store($medicalDate, $request->input('metadata', []));

            $medicalDate->save();

            return $medicalDate;
        });
    }

    private function generateOrder(string $date, Doctor $doctor)
    {
        $lastMedicalDate = MedicalDate::where('doctor_id', $doctor->id)->where('date', $date)->orderBy('shift', 'desc')->pluck('shift')->first();
        return $lastMedicalDate + 1;
    }
}
