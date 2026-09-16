<?php

namespace App\Http\Controllers\Api;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use App\Http\Services\OccupationalMedicineService;

class OccupationalMedicineController extends Controller
{
    public function __construct(private OccupationalMedicineService $occupationalMedicineService)
    {
    }

    public function store(MedicalDate $medicalDate, Request $request)
    {
        $document = $this->occupationalMedicineService->store($medicalDate, $request);
        return response()->json($document);
    }
}
