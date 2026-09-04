<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OccupationalMedicineService;

class OccupationalMedicineController extends Controller
{
    public function __construct(private OccupationalMedicineService $occupationalMedicineService)
    {
    }

    public function store(Request $request)
    {
        $document = $this->occupationalMedicineService->store($request);
        return response()->json($document);
    }
}
