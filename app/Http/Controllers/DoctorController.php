<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Http\Services\DoctorService;

class DoctorController extends Controller
{
    public function __construct(private DoctorService $doctorService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Doctor::paginate(10);
        return view('doctors.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $doctor = $this->doctorService->store($request);
        return redirect()->route('doctors.show', $doctor);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        // return response()->json($request->all());
        $doctor = $this->doctorService->update($request, $doctor);
        return redirect()->route('doctors.show', $doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
