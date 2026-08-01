<?php

namespace App\Http\Controllers;

use App\Models\OccupationalMedicalDate;

class OccupationalMedicineArchiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(OccupationalMedicalDate $occupationalMedicalDate)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado.');
        }

        $user = auth()->user();

        if (!$user->hasRole(['administrator', 'doctor'])) {
            abort(403, 'No autorizado.');
        }

        occu_storage()->makeDirectory('archives');

        $archiveRelative = "archives/{$occupationalMedicalDate->code}.zip";
        $archivePath = occu_storage()->path($archiveRelative);

        $zip = new \ZipArchive();
        $opened = $zip->open($archivePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        if ($opened !== true) {
            throw new \RuntimeException('No se pudo generar el archivo ZIP.');
        }

        foreach ($occupationalMedicalDate->medicalDates as $medicalDate) {

            if (!$medicalDate->certificate_id) {
                continue;
            }

            $relativeFile = $medicalDate->certificate->file;

            if (occu_storage()->exists($relativeFile)) {
                $absoluteFile = occu_storage()->path($relativeFile);
                $zip->addFile($absoluteFile, $medicalDate->specialty->name . ' - ' . basename($absoluteFile));
            }
        }

        $zip->close();

        return response()->download($archivePath)->deleteFileAfterSend(true);
    }
}
