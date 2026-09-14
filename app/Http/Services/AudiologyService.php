<?php

namespace App\Http\Services;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AudiologyService
{
    use DocumentService;

    public function __construct()
    {
        $this->documentTemplate = 'documents.audiology';
        $this->storageDiskPath = 'certificates/audiology';
    }

    public function store(MedicalDate $medicalDate, Request $request)
    {
        return DB::transaction(function () use ($medicalDate, $request) {

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
