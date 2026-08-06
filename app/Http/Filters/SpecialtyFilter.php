<?php

namespace App\Http\Filters;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyFilter
{
    public function query(Request $request)
    {
        $query = Specialty::query();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->input('name')}%");
        }

        return $query;
    }
}