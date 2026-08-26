<?php

namespace App\Http\Filters;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientFilter
{
    public function query(Request $request)
    {
        $query = Patient::query();

        if ($request->has('id_card')) {
            $query->whereHas('personalData', function ($q) use ($request) {
                $q->where('id_card', $request->input('id_card'));
            });
        }

        if ($request->has('first_name')) {
            $query->whereHas('personalData', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->input('first_name')}%");
            });
        }

        if ($request->has('last_name')) {
            $query->whereHas('personalData', function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->input('last_name')}%");
            });
        }

        if ($request->has('agreement_id')) {
            $query->where('agreement_id', $request->input('agreement_id'));
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