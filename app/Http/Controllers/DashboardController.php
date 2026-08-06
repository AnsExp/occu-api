<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialtyRequest;
use App\Models\Certificate;
use App\Models\MedicalDate;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Specialty $specialty)
    {
        $user = auth()->user();

        $date = request('date', date('Y-m-d'));

        if (!$user) {
            abort(403, 'No tiene permiso para acceder a este recurso.');
        }

        $query = MedicalDate::where('date', $date)->where('specialty_id', $specialty->id);

        if ($user->hasRole('doctor')) {
            $doctorId = $user->person?->doctor?->id;

            if (!$doctorId) {
                abort(403, 'No tiene permiso para acceder a este recurso.');
            }

            $query->where('doctor_id', $doctorId);
        } elseif (!$user->hasRole('administrator')) {
            abort(403, 'No tiene permiso para acceder a este recurso.');
        }

        $data = $query->orderBy('date', 'desc')->paginate(10);

        return view('dashboards.index', compact('specialty', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Specialty $specialty, MedicalDate $medicalDate)
    {
        if ($medicalDate->certificates->isNotEmpty()) {
            abort(403, 'Acceso denegado. Esta especialidad ya tiene un certificado asociado.');
        }
        return view('dashboards.create', compact('specialty', 'medicalDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403, 'Acceso denegado. Esta especialidad no tiene un formulario asociado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty, MedicalDate $medicalDate)
    {
        if ($medicalDate->certificates->isEmpty()) {
            abort(404, 'Certificado no encontrado.');
        }
        $filePath = $this->getFilePath($medicalDate->certificates->first());
        if (!$filePath) {
            abort(404, 'PDF file not found.');
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $medicalDate->code . '"',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty, MedicalDate $medicalDate)
    {
        return view('dashboards.edit', compact('specialty', 'medicalDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        abort(403, 'Acceso denegado. Esta especialidad no tiene un formulario asociado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty, MedicalDate $medicalDate)
    {
        abort(403, 'Acceso denegado. Esta especialidad no tiene un formulario asociado.');
    }

    private function getFilePath(Certificate $certificate)
    {
        $filePath = $certificate->file;
        if (!Storage::disk('local')->exists($filePath)) {
            return false;
        }
        return Storage::disk('local')->path($filePath);
    }
}
