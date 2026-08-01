<?php

namespace App\Http\Services;

use App\Models\Agreement;
use App\Models\Patient;
use App\Models\Person;
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

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));

            return $patient;
        });
    }

    public function update(Request $request, Patient $patient)
    {
        return DB::transaction(function () use ($request, $patient) {

            $this->personService->update($request, $patient->person);

            $this->manageAgreement($request, $patient);

            $this->metadataService->store($patient, $request->input('metadata', []));

            return $patient;
        });
    }

    public static function preparePerson(Person $person)
    {
        if ($person->patient) {
            return $person->patient;
        }

        $patient = $person->patient()->create();
        $person->user->assignRole('patient');

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

    // private function handleIdCardFile(Request $request, Patient $patient): void
    // {
    //     if (!$request->hasFile('id_card_file')) {
    //         return;
    //     }

    //     $idCardFile = $request->file('id_card_file');
    //     $extension = $idCardFile->getClientOriginalExtension();

    //     $path = $idCardFile->storeAs(
    //         'patients/id_cards',
    //         $patient->id_card . '.' . $extension,
    //         'local'
    //     );

    //     $patient->setIdCardFilePath($path);
    //     $patient->saveMeta();
    // }

    /**
     * Generate and store a PDF for the given patient.
     * @param Patient $patient The patient for whom the PDF is to be generated.
     * @return array<bool|string> Returns an array containing the file path and content of the generated PDF, or [false, false] if the operation fails.
     */
    // public function storePdf(Patient $patient)
    // {
    //     $pdf = Pdf::loadView('documents.patient', ['patient' => $patient]);
    //     $pdf->setPaper('A4', 'portrait');
    //     $pdf->setOption('isRemoteEnabled', true);
    //     $filePath = 'patients/records/' . $patient->id_card . '.pdf';
    //     $content = $pdf->output();
    //     if (Storage::disk('local')->put($filePath, $content)) {
    //         return [$filePath, $content];
    //     }
    //     return [false, false];
    // }
}
