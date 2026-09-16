<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OphthalmologyRequest;
use App\Http\Resources\DocumentResource;
use App\Http\Services\OphthalmologyService;
use App\Models\MedicalDate;

class OphthalmologyController extends Controller
{
    public function __construct(private OphthalmologyService $ophthalmologyService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDate $medicalDate, OphthalmologyRequest $request)
    {
        $ophthalmology = $this->ophthalmologyService->store($medicalDate, $request);
        return DocumentResource::make($ophthalmology);
    }
}
