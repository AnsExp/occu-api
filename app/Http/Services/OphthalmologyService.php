<?php

namespace App\Http\Services;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OphthalmologyService
{
    use DocumentService;

    public function __construct()
    {
        $this->documentTemplate = 'documents.ophthalmology';
        $this->storageDiskPath = 'certificates/ophthalmology';
    }

    public function store(Request $request)
    {
        $medicalDate = MedicalDate::findOrFail($request->input('medical_date.id'));
        return $this->createDocument($request, $medicalDate);
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
