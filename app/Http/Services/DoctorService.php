<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorService
{
    public function __construct(
        private PersonalDataService $personalDataService,
        private MetadataService $metadataService
    ) {
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $personalData = $this->personalDataService->store($request);

            if (!$personalData) {
                throw new \Exception('Failed to create personal data for doctor.');
            }

            $user = User::create([
                'name' => "{$personalData->first_name} {$personalData->last_name}",
                'email' => $personalData->email,
                'password' => bcrypt($personalData->id_card),
            ]);

            $user->assignRole('doctor');

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'personal_data_id' => $personalData->id,
                'specialty_id' => $request->input('specialty.id'),
                'is_occupational_doctor' => $request->input('is_occupational_doctor', false)
            ]);

            $this->metadataService->store($doctor, $request->input('metadata', []));

            return $doctor;
        });
    }

    public function update(Request $request, Doctor $doctor)
    {
        return DB::transaction(function () use ($request, $doctor) {

            $this->personalDataService->update($request, $doctor->personalData);

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
