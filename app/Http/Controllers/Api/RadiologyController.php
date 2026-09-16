<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RadiologyRequest;
use App\Http\Resources\MedicalDateResource;
use App\Http\Services\RadiologyService;
use App\Models\MedicalDate;
use Illuminate\Http\JsonResponse;

class RadiologyController extends Controller
{
    public function __construct(private RadiologyService $radiologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(MedicalDate $medicalDate, RadiologyRequest $request)
    {
        $radiology = $this->radiologyService->store($medicalDate, $request);
        return response()->json(MedicalDateResource::make($radiology), 201);
    }
}
