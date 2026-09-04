<?php

namespace App\Http\Services;

use App\Models\Document;
use App\Models\MedicalDate;
use Barryvdh\DomPDF\Facade\Pdf;
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


    public function store(Request $request)
    {
        return $this->createDocument($request, MedicalDate::findOrFail($request->input('medical_date.id')));
    }

    public function update(Request $request, MedicalDate $medicalDate)
    {
        return $this->createDocument($request, $medicalDate);
    }

    private function createDocument(Request $request, MedicalDate $medicalDate)
    {
        return DB::transaction(function () use ($request, $medicalDate) {
            $snapshot = $request->input('medical_exam', []);

            return $this->createVersionedDocument(
                $medicalDate,
                compact('medicalDate', 'snapshot'),
                $snapshot,
                $request->input('timezone'),
            );
        });
    }
}
