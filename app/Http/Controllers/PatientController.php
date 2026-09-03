<?php

namespace App\Http\Controllers;

use App\Http\Filters\PatientFilter;
use App\Http\Requests\PatientRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Patient;
use App\Http\Services\PatientService;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private PatientService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PatientFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([PatientResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Patients retrieved successfully' : 'No patients found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $patient = $this->service->store($request);
        return ApiResponse::data(PatientResource::make($patient), true, 'Patient created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return ApiResponse::data(null, false, 'Patient not found', 404);
        }
        return ApiResponse::data(PatientResource::make($patient), true, 'Patient retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return ApiResponse::data(null, false, 'Patient not found', 404);
        }
        $patient = $this->service->update($request, $patient);
        return ApiResponse::data(PatientResource::make($patient), true, 'Patient updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return ApiResponse::data(null, false, 'Patient not found', 404);
        }
        $patient->delete();
        return ApiResponse::message(null, true, 'Patient deleted successfully.', 200);
    }
}
