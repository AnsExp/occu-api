<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\MedicalDate;
use App\Models\Person;
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
            $person = Person::find($request->input('person.id'));
            $doctor = Doctor::find($request->input('doctor.id'));
            $specialty = Specialty::find($request->input('specialty.id'));

            $patient = PatientService::preparePerson($person);

            $medicalDate = new MedicalDate([
                'code' => MedicalDate::generateCode(),
                'timezone' => $request->input('timezone'),
                'date' => $request->input('date'),
                'price' => $specialty->price_base,
                'order' => $this->generateOrder($request->input('date'), $doctor),
            ]);

            $medicalDate->doctor()->associate($doctor);
            $medicalDate->specialty()->associate($specialty);
            $medicalDate->patient()->associate($patient);
            $medicalDate->save();

            return $medicalDate;
        });
    }

    public function update(Request $request, MedicalDate $medicalDate)
    {
        return DB::transaction(function () use ($request, $medicalDate) {
            $person = Person::find($request->input('person.id'));
            $doctor = Doctor::find($request->input('doctor.id'));
            $specialty = Specialty::find($request->input('specialty.id'));

            PatientService::preparePerson($person);

            $medicalDate->date = $request->input('date');
            $medicalDate->price = $specialty->price_base;
            $medicalDate->timezone = $request->input('timezone');
            $medicalDate->order = $this->generateOrder($request->input('date'), $doctor);
            $medicalDate->doctor()->associate($doctor);
            $medicalDate->specialty()->associate($specialty);
            $medicalDate->patient()->associate($person->patient);

            $this->metadataService->store($medicalDate, $request->input('metadata', []));

            $medicalDate->save();

            return $medicalDate;
        });
    }

    private function generateOrder(string $date, Doctor $doctor)
    {
        $lastMedicalDate = MedicalDate::where('date', $date)->where('doctor_id', $doctor->id)->orderBy('order', 'desc')->pluck('order')->first();
        return $lastMedicalDate + 1;
    }
}
