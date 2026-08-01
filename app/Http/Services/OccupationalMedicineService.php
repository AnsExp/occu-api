<?php

namespace App\Http\Services;

use App\Models\Certificate;
use App\Models\OccupationalMedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationalMedicineService
{
    protected $documentTemplate = 'documents.occupational_medicine';
    protected $storageDiskPath = 'certificates/occupational_medicine';

    public function store(Request $request)
    {
        return $this->persistCertificate($request, OccupationalMedicalDate::findOrFail($request->input('occupational_medical_date.id')));
    }

    public function update(Request $request, Certificate $certificate)
    {
        return $this->persistCertificate($request, OccupationalMedicalDate::findOrFail($request->input('occupational_medical_date.id')), $certificate);
    }

    private function persistCertificate(Request $request, OccupationalMedicalDate $medicalDate, ?Certificate $parentCertificate = null): Certificate
    {
        return DB::transaction(function () use ($request, $medicalDate, $parentCertificate) {
            [$file, $content] = $this->storePdf($medicalDate, $request->input('medical_exam'));

            if (!$file || !$content) {
                throw new \RuntimeException("Error al generar PDF del certificado.");
            }

            if ($parentCertificate) {
                $parentCertificate->delete();
            }

            $certificate = Certificate::create([
                'parent_id' => $parentCertificate?->id ?? null,
                'timezone' => $request->input('timezone'),
                'sha256' => occu_hash($content),
                'file' => $file,
                'snapshot' => $request->input('medical_exam', []),
            ]);

            $medicalDate->certificate()->associate($certificate);
            $medicalDate->save();

            return $certificate;
        });
    }

    /**
     * Genera y guarda el PDF del certificado.
     */
    private function storePdf(OccupationalMedicalDate $medicalDate, array $snapshot): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('medicalDate', 'snapshot'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $filePath = "{$this->storageDiskPath}/{$medicalDate->code}.pdf";
        $content = $pdf->output();
        return occu_storage()->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
