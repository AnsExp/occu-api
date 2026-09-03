<?php

namespace App\Http\Controllers;

use App\Http\Filters\SpecialtyFilter;
use App\Http\Requests\SpecialtyRequest;
use App\Models\Specialty;
use App\Http\Services\SpecialtyService;
use App\Http\Resources\SpecialtyResource;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

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
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([SpecialtyResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Specialties retrieved successfully' : 'No specialties found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialtyRequest $request)
    {
        $specialty = $this->specialtyService->store($request);
        return ApiResponse::data(SpecialtyResource::make($specialty), true, 'Specialty created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $specialty = Specialty::find($id);
        if (!$specialty) {
            return ApiResponse::data(null, false, 'Specialty not found', 404);
        }
        return ApiResponse::data(SpecialtyResource::make($specialty), true, 'Specialty retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, $id)
    {
        $specialty = Specialty::find($id);
        if (!$specialty) {
            return ApiResponse::data(null, false, 'Specialty not found', 404);
        }
        $specialty = $this->specialtyService->update($request, $specialty);
        return ApiResponse::data(SpecialtyResource::make($specialty), true, 'Specialty updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $specialty = Specialty::find($id);
        if (!$specialty) {
            return ApiResponse::data(null, false, 'Specialty not found', 404);
        }
        $specialty->delete();
        return ApiResponse::data(null, true, 'Specialty deleted successfully.', 200);
    }
}
