<?php

namespace App\Http\Services;

use App\Models\Medication;
use App\Models\PersonalData;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    use DocumentService;

    public function __construct(){
        $this->documentTemplate = 'documents.prescription';
        $this->storageDiskPath = 'prescriptions';
    }
    
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $prescription = Prescription::create([
                'code' => $this->generateCode(),
                'patient_id' => $this->preparePatientId($request),
                'doctor_id' => $request->input('doctor.id'),
                'timezone' => $request->input('timezone'),
                'notes' => $request->input('notes'),
            ]);

            $prescription->load('doctor', 'patient');
            $this->syncMedications($prescription, $request->input('items', []));
            $this->createDocument($request, $prescription);

            return $prescription;
        });
    }

    private function preparePatientId(Request $request): int
    {
        $person = PersonalData::findByIdCard($request->input('person.id_card'));
        $patient = PatientService::preparePatient($person);
        return $patient->id;
    }

    public function update(Request $request, Prescription $prescription)
    {
        return DB::transaction(function () use ($request, $prescription) {
            $prescription->update([
                'code' => $this->generateCode(),
                'patient_id' => $this->preparePatientId($request),
                'doctor_id' => $request->input('doctor.id'),
                'timezone' => $request->input('timezone'),
                'notes' => $request->input('notes'),
            ]);

            $prescription->load('doctor', 'patient');
            $this->syncMedications($prescription, $request->input('items', []));
            $this->createDocument($request, $prescription);

            return $prescription;
        });
    }

    private function syncMedications(Prescription $prescription, array $items): void
    {
        $prescription->medications()->delete();

        foreach ($items as $item) {
            $medicationModel = Medication::find($item['id']);
            $prescription->medications()->create([
                'medication_id' => $medicationModel->id,
                'name' => $medicationModel->name,
                'price' => $medicationModel->price,
                'quantity' => $item['quantity'],
                'notes' => $item['notes'],
            ]);
        }
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

    private function createDocument(Request $request, Prescription $prescription, bool $isNew = true): void
    {
        $this->documentParams = compact('prescription');
        $this->persistPdf();

        $latest = $prescription->documents()->latest('created_at')->first();
        $version = $isNew ? '1.0' : ($latest ? number_format(((float) $latest->version) + 0.1, 1) : '1.0');

        $prescription->documents()->create([
            'version' => $version,
            'timezone' => $request->input('timezone'),
            'snapshot' => $request->all(),
            'sha256' => occu_hash($this->content),
            'file' => $this->filePath,
        ]);
    }
}
