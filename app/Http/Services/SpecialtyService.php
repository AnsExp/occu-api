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
            $specialty = Specialty::create([
                'name' => $request->input('name'),
                'slug' => occu_slug($request->input('name')),
                'price_base' => $request->input('price_base'),
                'description' => $request->input('description'),
            ]);
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
