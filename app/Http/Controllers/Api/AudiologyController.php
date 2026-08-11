<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AudiologyRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Services\AudiologyService;

class AudiologyController extends Controller
{
    public function __construct(private AudiologyService $audiologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AudiologyRequest $request)
    {
        $audiology = $this->audiologyService->store($request);
        return CertificateResource::make($audiology);
    }
}
