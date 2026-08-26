<?php

namespace App\Http\Services;

use App\Models\LaboratoryOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryOptionService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $option = LaboratoryOption::create($request->validated());
            return $option;
        });
    }

    public function update(Request $request, LaboratoryOption $laboratoryOption)
    {
        return DB::transaction(function () use ($request, $laboratoryOption) {
            $laboratoryOption->update($request->validated());
            return $laboratoryOption;
        });
    }
}
