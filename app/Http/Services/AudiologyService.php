<?php

namespace App\Http\Services;

use App\Models\Certificate;
use App\Models\MedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AudiologyService
{
    protected $documentTemplate = 'documents.audiology';
    protected $storageDiskPath = 'certificates/audiology';

    public function store(Request $request)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('medical_date.id')));
    }

    public function update(Request $request, Certificate $certificate)
    {
        return $this->persistCertificate($request, MedicalDate::findOrFail($request->input('medical_date.id')));
    }

    private function persistCertificate(Request $request, MedicalDate $medicalDate): Certificate
    {
        return DB::transaction(function () use ($request, $medicalDate) {

            [$file, $content] = $this->storePdf($medicalDate, $request->input('medical_exam', []));

            if (!$file || !$content) {
                throw new \RuntimeException("Error al generar PDF del certificado.");
            }

            if ($certificate = $medicalDate->certificate) {
                $certificate->delete();
            }

            $certificate = Certificate::create([
                'medical_date_id' => $medicalDate->id ?? null,
                'timezone' => $request->input('timezone'),
                'sha256' => occu_hash($content),
                'file' => $file,
                'snapshot' => $request->input('medical_exam', []),
            ]);

            return $certificate;
        });
    }

    /**
     * Genera y guarda el PDF del certificado.
     */
    private function storePdf(MedicalDate $medicalDate, array $snapshot): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('medicalDate', 'snapshot'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $content = $pdf->output();

        $storage = occu_storage();
        $offset = 0;
        do {
            $filePath = "{$this->storageDiskPath}/{$medicalDate->code}" . ($offset > 0 ? "_{$offset}" : "") . ".pdf";
            $offset++;
        } while ($storage->exists($filePath));

        return $storage->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
