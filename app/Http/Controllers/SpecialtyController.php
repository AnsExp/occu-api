<?php

namespace App\Http\Controllers;

use App\Http\Filters\SpecialtyFilter;
use App\Http\Requests\SpecialtyRequest;
use App\Models\Specialty;
use App\Http\Services\SpecialtyService;
use App\Http\Resources\SpecialtyResource;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function __construct(private SpecialtyService $specialtyService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SpecialtyFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request)->paginate($perPage);
        return SpecialtyResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialtyRequest $request)
    {
        $specialty = $this->specialtyService->store($request);
        return SpecialtyResource::make($specialty);
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return SpecialtyResource::make($specialty);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        $specialty = $this->specialtyService->update($request, $specialty);
        return SpecialtyResource::make($specialty);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return response()->json(['message' => 'Specialty deleted successfully']);
    }
}
