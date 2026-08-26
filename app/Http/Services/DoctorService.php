<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\Person;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorService
{
    public function __construct(
        private PersonService $personService,
        private MetadataService $metadataService
    ) {
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = $this->personService->store($request);

            if (!$person) {
                throw new \Exception('Failed to create person');
            }

            $doctor = $person->doctor()->create([
                'specialty_id' => $request->input('specialty.id'),
                'is_occupational_doctor' => $request->input('is_occupational_doctor', false)
            ]);
            $person->user->assignRole('doctor');

            $this->metadataService->store($doctor, $request->input('metadata', []));

            return $doctor;
        });
    }

    public function update(Request $request, Doctor $doctor)
    {
        return DB::transaction(function () use ($request, $doctor) {

            $this->personService->update($request, $doctor->personalData);

            $this->manageSpecialty($request, $doctor);

            $this->metadataService->store($doctor, $request->input('metadata', []));

            return $doctor;
        });
    }

    private function manageSpecialty(Request $request, Doctor $doctor)
    {
        $specialtyId = $request->input('specialty.id');
        $isOccupationalDoctor = $request->input('is_occupational_doctor', false);

        $doctor->specialty()->associate(
            $specialtyId ? Specialty::find($specialtyId) : null
        );

        $doctor->is_occupational_doctor = $isOccupationalDoctor;

        $doctor->save();
    }
}
