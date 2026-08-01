<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialtyRequest;
use App\Http\Services\SpecialtyService;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function __construct(private SpecialtyService $specialtyService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Specialty::orderBy('name')->paginate(10);
        return view('specialties.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialtyRequest $request)
    {
        $specialty = $this->specialtyService->store($request);
        return redirect()->route('specialties.show', $specialty);
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        $specialty = $this->specialtyService->update($request, $specialty);
        return redirect()->route('specialties.show', $specialty);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return redirect()->route('specialties.index');
    }
}
