<?php

namespace App\Http\Controllers;

use App\Http\Requests\OccupationalMedicalDateRequest;
use App\Http\Services\OccupationalMedicalDateService;
use App\Models\OccupationalMedicalDate;
use Illuminate\Http\RedirectResponse;

class OccupationalMedicalDateController extends Controller
{
    public function __construct(private OccupationalMedicalDateService $groupMedicalDateService)
    {
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'No tienen permitido acceder a este recurso.');
        }
        if ($user->hasRole('administrator')) {
            $data = OccupationalMedicalDate::paginate(10);
        } else if ($user->hasRole('doctor')) {
            if ($user?->person?->doctor?->is_occupational_doctor) {
                $data = OccupationalMedicalDate::where('occupational_doctor_id', $user->person->doctor->id)->paginate(10);
            } else {
                abort(403, 'No tienen permitido acceder a este recurso.');
            }
        }
        return view('occupational_medical_dates.index', compact('data'));
    }

    public function show(OccupationalMedicalDate $occupationalMedicalDate)
    {
        return view('occupational_medical_dates.show', compact('occupationalMedicalDate'));
    }

    public function create()
    {
        return view('occupational_medical_dates.create');
    }

    public function store(OccupationalMedicalDateRequest $request): RedirectResponse
    {
        $this->groupMedicalDateService->store($request);
        return redirect()->route('medical_dates.index')->with('success', 'Citas médicas ocupacionales registradas correctamente.');
    }
}
