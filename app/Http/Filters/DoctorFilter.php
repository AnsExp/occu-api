<?php

namespace App\Http\Filters;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorFilter
{
    public function query(Request $request)
    {
        $query = Doctor::query();

        if ($request->has('is_occupational_doctor')) {
            $query->where('is_occupational_doctor', filter_var($request->input('is_occupational_doctor'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('id_card')) {
            $query->whereHas('person', function ($q) use ($request) {
                $q->where('id_card', $request->input('id_card'));
            });
        }

        if ($request->has('first_name')) {
            $query->whereHas('person', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->input('first_name')}%");
            });
        }

        if ($request->has('last_name')) {
            $query->whereHas('person', function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->input('last_name')}%");
            });
        }

        if ($request->has('specialty_id')) {
            $query->where('specialty_id', $request->input('specialty_id'));
        }

        return $query;
    }
}