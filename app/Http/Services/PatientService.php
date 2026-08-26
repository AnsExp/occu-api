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
        private PersonService $personService,
        private MetadataService $metadataService
    ) {
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = $this->personService->store($request);

            if (!$person) {
                throw new \Exception('Failed to create person for patient.');
            }

            $patient = self::preparePerson($person);

            if (!$patient) {
                throw new \Exception(json_encode($patient));
            }

            $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'email_hash' => occu_hash($request->input('email')),
                'password' => bcrypt($request->input('id_card')),
            ]);

            $patient->user()->associate($user);
            $patient->save();

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));
            $this->handleIdCardFile($request, $patient);

            return $patient;
        });
    }

    public function update(Request $request, Patient $patient)
    {
        return DB::transaction(function () use ($request, $patient) {

            $this->personService->update($request, $patient->personalData);

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));
            $this->handleIdCardFile($request, $patient);

            return $patient;
        });
    }

    public static function preparePerson(PersonalData $personalData)
    {
        if ($personalData->patient) {
            return $personalData->patient;
        }
        $patient = $personalData->patient()->create();
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

    private function handleIdCardFile(Request $request, Patient $patient): void
    {
        if (!$request->hasFile('id_card_file')) {
            return;
        }

        $file = $request->file('id_card_file');
        $content = $file->getContent();
        $path = 'patients/id_cards/' . $patient->personalData->id_card . '.pdf';
        $saved = occu_storage()->put($path, $content);

        if ($saved) {
            $patient->personalData->update(['id_card_file' => $path]);
        }
    }
}
