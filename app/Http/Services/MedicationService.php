<?php

namespace App\Http\Services;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicationService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return Medication::create($request->only(['name', 'price']));
        });
    }

    public function update(Request $request, Medication $medication)
    {
        return DB::transaction(function () use ($request, $medication) {
            $medication->update($request->only(['name', 'price']));
            return $medication;
        });
    }
}
