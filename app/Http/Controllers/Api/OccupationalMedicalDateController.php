<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OccupationalMedicalDateRequest;
use App\Models\MedicalDate;
use App\Http\Services\OccupationalMedicalDateService;
use App\Http\Resources\MedicalDateResource;
use Illuminate\Http\Request;
use App\Http\Filters\MedicalDateFilter;

class OccupationalMedicalDateController extends Controller
{
    public function __construct(private OccupationalMedicalDateService $medicalDateService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicalDateFilter $filter)
    {
        $user = $request->user();
        $request->merge(['type' => 'occupational']);
        if ($user->hasRole('doctor')) {
            if ($user->person?->doctor?->is_occupational_doctor) {
                $request->merge([
                    'doctor_id' => $user->person->doctor->id,
                ]);
            }
        } else if ($user->hasRole('patient')) {
            $request->merge([
                'patient_id' => $user->person->patient->id,
            ]);
        }
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return MedicalDateResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OccupationalMedicalDateRequest $request)
    {
        $medicalDate = $this->medicalDateService->store($request);
        return MedicalDateResource::make($medicalDate);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalDate $medicalDate)
    {
        return MedicalDateResource::make($medicalDate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OccupationalMedicalDateRequest $request, MedicalDate $medicalDate)
    {
        $medicalDate = $this->medicalDateService->update($request, $medicalDate);
        return MedicalDateResource::make($medicalDate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalDate $medicalDate)
    {
        $medicalDate->delete();
        return response()->json(['message' => 'Medical date deleted successfully']);
    }
}
