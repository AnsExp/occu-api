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
