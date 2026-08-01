<?php

namespace App\Http\Services;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialtyService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $specialty = Specialty::create($request->all());
            return $specialty;
        });
    }

    public function update(Request $request, Specialty $specialty)
    {
        return DB::transaction(function () use ($request, $specialty) {
            $specialty->update($request->all());
            return $specialty;
        });
    }
}
