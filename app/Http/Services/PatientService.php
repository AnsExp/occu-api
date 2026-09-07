<?php

namespace App\Http\Services;

use App\Models\Agreement;
use App\Models\Patient;
use App\Models\PersonalData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientService
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
                throw new \Exception('Failed to create personal data for patient.');
            }

            $patient = self::preparePatient($personalData);

            if (!$patient) {
                throw new \Exception(json_encode($patient));
            }

            $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('id_card')),
            ]);

            $patient->user()->associate($user);
            $patient->save();

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));

            return $patient;
        });
    }

    public function update(Request $request, Patient $patient)
    {
        return DB::transaction(function () use ($request, $patient) {

            $this->personalDataService->update($request, $patient->personalData);

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));

            return $patient;
        });
    }

    public static function preparePatient(PersonalData $personalData)
    {
        if ($personalData->patient) {
            return $personalData->patient;
        }
        $user = User::create([
            'name' => $personalData->first_name . ' ' . $personalData->last_name,
            'email' => $personalData->email,
            'password' => bcrypt($personalData->id_card),
        ]);
        $user->assignRole('patient');
        $patient = $personalData->patient()->create([
            'user_id' => $user->id,
        ]);
        return $patient;
    }

    private function manageAgreement(Request $request, Patient $patient): void
    {
        $agreementId = $request->input('agreement.id');

        $patient->agreement()->associate(
            $agreementId ? Agreement::find($agreementId) : null
        );

        $patient->save();
    }
}
