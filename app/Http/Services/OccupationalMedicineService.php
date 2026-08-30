<?php

namespace App\Http\Services;

use App\Models\Document;
use App\Models\MedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationalMedicineService
{
    protected $documentTemplate = 'documents.occupational_medicine';
    protected $storageDiskPath = 'certificates/occupational_medicine';

    public function store(Request $request)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('occupational_medical_date.id')));
    }

    public function update(Request $request)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('occupational_medical_date.id')));
    }

    private function persistCertificate(Request $request, MedicalDate $medicalDate): Document
    {
        return DB::transaction(function () use ($request, $medicalDate) {
            [$file, $content] = $this->storePdf($medicalDate, $request->input('medical_exam'));

            if (!$file || !$content) {
                throw new \RuntimeException("Error al generar PDF del certificado.");
            }

            $medicalDate->document()->create([
                'timezone' => $request->input('timezone'),
                'snapshot' => $request->input('medical_exam', []),
                'sha256' => occu_hash($content),
                'file' => $file,
            ]);

            return $medicalDate->document()->first();
        });
    }

    /**
     * Genera y guarda el PDF del certificado.
     */
    private function storePdf(MedicalDate $medicalDate, array $snapshot): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('medicalDate', 'snapshot'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $filePath = "{$this->storageDiskPath}/{$medicalDate->code}.pdf";
        $content = $pdf->output();
        return occu_storage()->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
