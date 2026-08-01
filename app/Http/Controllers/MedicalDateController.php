<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalDateRequest;
use App\Models\MedicalDate;
use App\Http\Services\MedicalDateService;

class MedicalDateController extends Controller
{
    public function __construct(private MedicalDateService $medicalDateService)
    {
        $this->authorizeResource(MedicalDate::class, 'medicalDate');
    }

    public function json()
    {
        $data = MedicalDate::with(['doctor.person', 'specialty'])->paginate(2);

        $custom = [
            'meta' => [
                'current_page' => $data->currentPage(),
                'previous_page' => $data->previousPageUrl(),
                'last_page' => $data->lastPage(),
                'next_page' => $data->nextPageUrl(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
            ],
            'data' => $data->map(fn($date) => [
                'code' => $date->code,
                'date' => $date->date,
                'doctor' => $date->doctor?->person?->fullname,
                'specialty' => $date->specialty?->name,
                'certificate_url' => route('dashboard.show', ['specialty' => $date->specialty?->slug, 'medicalDate' => $date->code]),
            ]),
        ];

        return response()->json($custom);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'No tiene permiso para acceder a este recurso.');
        }

        if ($user->hasRole('administrator')) {
            $data = MedicalDate::orderBy('date', 'desc')->paginate(10);
        } elseif ($user->hasRole('doctor')) {
            $data = MedicalDate::where('doctor_id', $user->person->doctor->id)->orderBy('date', 'desc')->paginate(10);
        } else {
            abort(403, 'No tienes permiso para acceder a este recurso');
        }

        return view('medical_dates.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medical_dates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDateRequest $request)
    {
        $medical_date = $this->medicalDateService->store($request);
        return redirect()->route('medical_dates.show', compact('medical_date'));
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalDate $medicalDate)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'No tiene permiso para acceder a este recurso.');
        }

        return view('medical_dates.show', compact('medicalDate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalDate $medicalDate)
    {
        return view('medical_dates.edit', compact('medicalDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalDateRequest $request, MedicalDate $medicalDate)
    {
        // return response()->json($request->all());
        $medical_date = $this->medicalDateService->update($request, $medicalDate);
        return redirect()->route('medical_dates.show', compact('medical_date'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalDate $medicalDate)
    {
        abort(403, 'No tienes permitido realizar esta acción. Ponte en contacto con el equipo de sistemas.');
    }
}
