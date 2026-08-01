<?php

namespace App\Http\Services;

use App\Models\Certificate;
use App\Models\MedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OphthalmologyService
{
    private string $documentTemplate = 'documents.ophthalmology';
    private string $storageDiskPath = 'certificates/ophthalmology';

    public function store(Request $request)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('medical_date.id')));
    }

    public function update(Request $request, Certificate $certificate)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('medical_date.id')), $certificate);
    }

    private function persistCertificate(Request $request, MedicalDate $medicalDate, ?Certificate $parentCertificate = null): Certificate
    {
        return DB::transaction(function () use ($request, $medicalDate, $parentCertificate) {

            if ($parentCertificate) {
                $parentCertificate->delete();
            }

            $certificate = new Certificate([
                'parent_id' => $parentCertificate?->id ?? null,
                'timezone' => $request->input('timezone'),
                'sha256' => 'temp',
                'file' => 'temp',
                'snapshot' => $request->input('medical_exam', []),
            ]);

            [$file, $content] = $this->storePdf($medicalDate, $certificate);

            if (!$file || !$content) {
                throw new \RuntimeException("Error al generar PDF del certificado.");
            }

            $certificate->file = $file;
            $certificate->sha256 = occu_hash($content);
            $certificate->save();

            $medicalDate->certificate()->associate($certificate);
            $medicalDate->save();

            return $certificate;
        });
    }

    /**
     * Genera y guarda el PDF del certificado.
     */
    private function storePdf(MedicalDate $medicalDate, Certificate $certificate): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('medicalDate', 'certificate'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $filePath = "{$this->storageDiskPath}/{$medicalDate->code}.pdf";
        $content = $pdf->output();
        return Storage::disk('local')->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
