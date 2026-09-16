<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OdontologyRequest;
use App\Http\Resources\MedicalDateResource;
use App\Http\Services\OdontologyService;
use App\Models\MedicalDate;

class OdontologyController extends Controller
{
    public function __construct(private OdontologyService $odontologyService)
    {
    }
    
    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDate $medicalDate, OdontologyRequest $request)
    {
        $odontology = $this->odontologyService->store($medicalDate, $request);
        return response()->json(MedicalDateResource::make($odontology), 201);
    }
}
