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