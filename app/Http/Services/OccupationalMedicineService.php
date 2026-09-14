<?php

namespace App\Http\Services;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationalMedicineService
{
    use DocumentService;

    public function __construct()
    {
        $this->documentTemplate = 'documents.occupational_medicine';
        $this->storageDiskPath = 'certificates/occupational_medicine';
    }


    public function store(MedicalDate $medicalDate, Request $request)
    {
        return DB::transaction(function () use ($request, $medicalDate) {

            $snapshot = $request->input('medical_exam', []);

            $this->createVersionedDocument(
                $medicalDate,
                compact('medicalDate', 'snapshot'),
                $snapshot,
                $request->input('timezone'),
            );

            return $medicalDate;
        });
    }
}
