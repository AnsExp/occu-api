<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Policies\PatientPolicy;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    private PatientPolicy $policy;

    public function __construct()
    {
        $this->policy = new PatientPolicy();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->policy->viewAny(request()->user())) {
            abort(403, 'No tienes permiso para acceder a los pacientes.');
        }
        $sort = request('sort', 'first_name');
        $direction = request('direction', 'asc');
        $data = Patient::orderBy($sort, $direction)
            ->paginate(get_setting('pagination_per_page', 10))
            ->withQueryString();
        return view('pages.patients', compact('data', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!$this->policy->create(request()->user())) {
            abort(403, 'No tienes permiso para crear pacientes.');
        }
        return view('forms.patients', ['patient' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        if (!$this->policy->create(request()->user())) {
            abort(403, 'No tienes permiso para crear pacientes.');
        }
        $validated = $request->validated();

        $patient = new Patient($validated);

        if ($request->hasFile('id_card_file')) {
            $patient->id_card_file_path = $request->file('id_card_file')->store('patients/id-cards', 'public');
        }

        $patient->save();
        return redirect()->route('patients.edit', ['patient' => $patient])->with('status', 'Paciente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        if (!$this->policy->update(request()->user(), $patient)) {
            abort(403, 'No tienes permiso para editar pacientes.');
        }
        $patient->load('metadata');
        return view('forms.patients', ['patient' => $patient]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        if (!$this->policy->update(request()->user(), $patient)) {
            abort(403, 'No tienes permiso para editar pacientes.');
        }
        $validated = $request->validated();

        if ($request->hasFile('id_card_file')) {
            if ($patient->id_card_file_path) {
                Storage::disk('public')->delete($patient->id_card_file_path);
            }

            $id_card_file_path = $request->file('id_card_file')->store('patients/id-cards', 'public');
            $patient->setMeta('id_card_file_path', $id_card_file_path);
        }

        $patient->update($validated);
        return redirect()->route('patients')->with('status', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        if (!$this->policy->delete(request()->user(), $patient)) {
            abort(403, 'No tienes permiso para eliminar pacientes.');
        }
        $patient->delete();
        return redirect()->route('patients')->with('status', 'Paciente eliminado correctamente.');
    }
}
