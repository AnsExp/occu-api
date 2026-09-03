<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudiologyRequest;
use App\Http\Resources\DocumentResource;
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
    public function store(AudiologyRequest $request)
    {
        $audiology = $this->audiologyService->store($request);
        return response()->json(DocumentResource::make($audiology), 201);
    }

    public function update(AudiologyRequest $request, MedicalDate $medicalDate)
    {
        $newAudiology = $this->audiologyService->update($request, $medicalDate);
        return response()->json(DocumentResource::make($newAudiology), 200);
    }
}
