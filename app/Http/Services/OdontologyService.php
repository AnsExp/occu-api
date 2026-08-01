<?php

namespace App\Http\Services;

use App\Models\Certificate;
use App\Models\MedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OdontologyService
{
    private string $documentTemplate = 'documents.odontology';
    private string $storageDiskPath = 'certificates/odontology';

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

    private function storePdf(MedicalDate $medicalDate, array $snapshot): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, compact('medicalDate', 'snapshot'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $filePath = "{$this->storageDiskPath}/{$medicalDate->code}.pdf";
        $content = $pdf->output();
        return Storage::disk('local')->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
