<?php

namespace App\Http\Filters;

use App\Models\PersonalData;
use Illuminate\Http\Request;

class PersonFilter
{
    public function query(Request $request)
    {
        $query = PersonalData::query();

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

        if ($request->has('order_by')) {
            $orderBy = $request->input('order_by');
            $order = $request->input('order', 'asc');
            $query->orderBy($orderBy, $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }
}