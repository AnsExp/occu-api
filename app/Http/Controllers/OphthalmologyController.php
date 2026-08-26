<?php

namespace App\Http\Controllers;

use App\Http\Requests\OphthalmologyRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Services\OphthalmologyService;

class OphthalmologyController extends Controller
{
    public function __construct(private OphthalmologyService $ophthalmologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OphthalmologyRequest $request)
    {
        $ophthalmology = $this->ophthalmologyService->store($request);
        return CertificateResource::make($ophthalmology);
    }
}
