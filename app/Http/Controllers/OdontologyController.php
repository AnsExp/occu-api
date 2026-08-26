<?php

namespace App\Http\Controllers;

use App\Http\Requests\OdontologyRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Services\OdontologyService;

class OdontologyController extends Controller
{
    public function __construct(private OdontologyService $odontologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OdontologyRequest $request)
    {
        $odontology = $this->odontologyService->store($request);
        return CertificateResource::make($odontology);
    }
}
