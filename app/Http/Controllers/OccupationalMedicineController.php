<?php

namespace App\Http\Controllers;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use App\Http\Services\OccupationalMedicineService;

class OccupationalMedicineController extends Controller
{
    public function __construct(private OccupationalMedicineService $occupationalMedicineService)
    {
    }

    public function create(MedicalDate $medicalDate)
    {
        return view('occupational_medicine.create', compact('medicalDate'));
    }

    public function edit(MedicalDate $medicalDate)
    {
        // return view('occupational_medicine.create', compact('medicalDate'));
    }

    public function store(Request $request)
    {
        $this->occupationalMedicineService->store($request);
        return response()->json($request->all());
    }
}
