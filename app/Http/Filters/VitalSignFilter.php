<?php

namespace App\Http\Filters;

use App\Models\VitalSign;
use Illuminate\Http\Request;

class VitalSignFilter
{
    public function query(Request $request)
    {
        $query = VitalSign::query();

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->input('patient_id'));
        }

        if ($request->has('medical_date_id')) {
            $query->where('medical_date_id', $request->input('medical_date_id'));
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