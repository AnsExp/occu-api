<?php

namespace App\Http\Services;

use App\Models\Medication;
use App\Models\PersonalData;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    private $documentTemplate = 'documents.prescription';
    private $storageDiskPath = 'documents/prescriptions';

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $person = PersonalData::find($request->input('person.id'));
            $patient = PatientService::preparePerson($person);

            $prescription = Prescription::create([
                'code' => $this->generateCode(),
                'doctor_id' => $request->input('doctor.id'),
                'patient_id' => $patient->id,
                'timezone' => $request->input('timezone'),
                'notes' => $request->input('notes'),
                'sha256' => 'temp',
                'file' => 'temp',
                'snapshot' => $request->all(),
            ]);

            foreach ($request->input('medications', []) as $medication) {
                $medicationModel = Medication::find($medication['id']);
                $prescription->medications()->create([
                    'medication_id' => $medicationModel->id,
                    'name' => $medicationModel->name,
                    'price' => $medicationModel->price,
                    'quantity' => $medication['quantity'],
                    'notes' => $medication['notes'],
                ]);
            }

            $prescription->load('doctor', 'patient');

            [$filePath, $content] = $this->storePdf($prescription);

            if ($filePath && $content) {
                $prescription->update([
                    'file' => $filePath,
                    'sha256' => occu_hash($content),
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

    private function storePdf(Prescription $prescription)
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('prescription'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $filePath = "{$this->storageDiskPath}/{$prescription->code}.pdf";
        $content = $pdf->output();
        return occu_storage()->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
