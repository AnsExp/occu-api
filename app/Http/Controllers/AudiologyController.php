<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudiologyRequest;
use App\Http\Resources\MedicalDateResource;
use App\Http\Services\AudiologyService;
use App\Models\MedicalDate;
use Illuminate\Http\JsonResponse;

class AudiologyController extends Controller
{
    public function __construct(private AudiologyService $audiologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(MedicalDate $medicalDate, AudiologyRequest $request)
    {
        $audiology = $this->audiologyService->store($medicalDate, $request);
        return response()->json(MedicalDateResource::make($audiology), 201);
    }
}
