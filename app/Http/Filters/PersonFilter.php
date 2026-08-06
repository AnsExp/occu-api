<?php

namespace App\Http\Filters;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonFilter
{
    public function query(Request $request)
    {
        $query = Person::query();

        if ($request->has('first_name')) {
            $query->where('first_name', 'like', "%{$request->input('first_name')}%");
        }

        if ($request->has('last_name')) {
            $query->where('last_name', 'like', "%{$request->input('last_name')}%");
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', "%{$request->input('phone')}%");
        }

        if ($request->has('id_card')) {
            $query->where('id_card', 'like', "%{$request->input('id_card')}%");
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->has('birth_date')) {
            $query->where('birth_date', $request->input('birth_date'));
        }

        if ($request->has('nationality')) {
            $query->where('nationality', 'like', "%{$request->input('nationality')}%");
        }

        return $query;
    }
}