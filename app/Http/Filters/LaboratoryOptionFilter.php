<?php

namespace App\Http\Filters;

use App\Models\LaboratoryOption;
use Illuminate\Http\Request;

class LaboratoryOptionFilter
{
    public function query(Request $request)
    {
        $query = LaboratoryOption::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->has('price_between')) {
            [$min, $max] = explode(',', $request->input('price_between'));
            $query->whereBetween('price', [(float) $min, (float) $max]);
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