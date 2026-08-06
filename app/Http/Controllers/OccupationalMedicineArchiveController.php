<?php

namespace App\Http\Controllers;

use App\Models\MedicalDate;

class OccupationalMedicineArchiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MedicalDate $medicalDate)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado.');
        }

        $user = auth()->user();

        if (!$user->can('read.certificates') && !$user->can('read.medical-dates')) {
            abort(403, 'No autorizado.');
        }

        $storage = occu_storage();

        $storage->makeDirectory('archives');

        $archiveRelative = "archives/{$medicalDate->code}.zip";
        $archivePath = $storage->path($archiveRelative);

        $zip = new \ZipArchive();
        $opened = $zip->open($archivePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        if ($opened !== true) {
            throw new \RuntimeException('No se pudo generar el archivo ZIP.');
        }

        foreach ($medicalDate->relationship as $medicalDate) {

            if (!$medicalDate->related->certificates()->first()?->id) {
                continue;
            }

            $relativeFile = $medicalDate->related->certificates()->first()?->file;

            if ($storage->exists($relativeFile)) {
                $absoluteFile = $storage->path($relativeFile);
                $zip->addFile($absoluteFile, $medicalDate->related->specialty->name . ' - ' . basename($absoluteFile));
            }
        }

        $zip->close();

        return response()->download($archivePath)->deleteFileAfterSend(true);
    }
}
