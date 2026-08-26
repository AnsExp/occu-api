<?php

namespace App\Http\Controllers;

use App\Http\Filters\DoctorFilter;
use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Http\Services\DoctorService;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(private DoctorService $doctorService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DoctorFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request)->paginate($perPage);
        return DoctorResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $doctor = $this->doctorService->store($request);
        return DoctorResource::make($doctor);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return DoctorResource::make($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor = $this->doctorService->update($request, $doctor);
        return DoctorResource::make($doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
