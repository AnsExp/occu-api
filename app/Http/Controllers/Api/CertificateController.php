<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use App\Models\MedicalDate;

use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index()
    {
        return Certificate::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalDate $medicalDate)
    {
        if ($path = $this->getFilePath($medicalDate->certificates()->first())) {

            $user = auth()->user();

            if ($user->hasRole('administrator')) {
                return $this->response($path, $medicalDate->code);
            }

            if ($user->hasRole('doctor') && $user->person?->doctor?->id === $medicalDate->doctor_id) {
                return $this->response($path, $medicalDate->code);
            }

            if ($user->hasRole('patient') && $user->person?->patient?->id === $medicalDate->patient_id) {
                return $this->response($path, $medicalDate->code);
            }

            return response()->json(['message' => 'No tiene permiso para acceder a este recurso.'], 403);

        } else {

            return response()->json(['message' => 'El archivo no existe.'], 404);

        }
    }

    private function response(string $path, string $fileName)
    {
        return response()->file($path, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $fileName . '"',]);
    }

    private function getFilePath(Certificate $certificate)
    {
        $storage = occu_storage();

        if (!$storage->exists($certificate->file)) {
            return false;
        }

        return $storage->path($certificate->file);
    }
}
