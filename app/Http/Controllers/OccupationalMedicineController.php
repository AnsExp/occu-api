<?php

namespace App\Http\Controllers;

use App\Models\OccupationalMedicalDate;
use Illuminate\Http\Request;
use App\Http\Services\OccupationalMedicineService;

class OccupationalMedicineController extends Controller
{
    public function __construct(private OccupationalMedicineService $occupationalMedicineService)
    {
    }

    public function create(OccupationalMedicalDate $occupationalMedicalDate)
    {
        return view('occupational_medicine.create', compact('occupationalMedicalDate'));
    }

    public function edit(OccupationalMedicalDate $occupationalMedicalDate)
    {
        // return view('occupational_medicine.create', compact('occupationalMedicalDate'));
    }

    public function store(Request $request)
    {
        $this->occupationalMedicineService->store($request);
        return response()->json($request->all());
    }
}
