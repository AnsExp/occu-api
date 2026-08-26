<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MedicalDateRequest;
use App\Models\MedicalDate;
use App\Http\Services\MedicalDateService;
use App\Http\Resources\MedicalDateResource;
use Illuminate\Http\Request;
use App\Http\Filters\MedicalDateFilter;

class MedicalDateController extends Controller
{
    public function __construct(private MedicalDateService $medicalDateService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicalDateFilter $filter)
    {
        // $request->merge(['type' => 'normal']);
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return MedicalDateResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDateRequest $request)
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

    public function file(MedicalDate $medicalDate)
    {
        $certificate = $medicalDate->certificate;
        if (!$certificate || !$certificate->file || !occu_storage()->exists($certificate->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($certificate->file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalDateRequest $request, MedicalDate $medicalDate)
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
