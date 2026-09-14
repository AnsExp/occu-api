<?php

namespace App\Http\Services;

use App\Models\MedicalDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadiologyService
{
    public function store(MedicalDate $medicalDate, Request $request)
    {
        return DB::transaction(function () use ($medicalDate, $request) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $path = 'certificates/radiology/' . $medicalDate->code . '-' . rand() . '.' . $file->getClientOriginalExtension();
                occu_storage()->put($path, $file->getContent());
                $medicalDate->documents()->create([
                    'timezone' => $request->input('timezone'),
                    'sha256' => occu_hash($file->getContent()),
                    'file' => $path,
                ]);
            }
            return $medicalDate;
        });
    }
}
