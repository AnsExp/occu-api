<?php

namespace App\Http\Filters;

use App\Models\LaboratoryOrder;
use Illuminate\Http\Request;

class LaboratoryOrderFilter
{
    public function query(Request $request)
    {
        $query = LaboratoryOrder::query();

        if ($request->has('patient_id_card')) {
            $query->whereHas('patient.personalData', function ($q) use ($request) {
                $q->where('id_card', $request->input('patient_id_card'));
            });
        }

        if ($request->has('patient_id')) {
            $query->whereHas('patient.personalData', function ($q) use ($request) {
                $q->where('id', $request->input('patient_id'));
            });
        }

        if ($request->has('doctor_id_card')) {
            $query->whereHas('doctor.personalData', function ($q) use ($request) {
                $q->where('id_card', $request->input('doctor_id_card'));
            });
        }

        if ($request->has('doctor_id')) {
            $query->whereHas('doctor.personalData', function ($q) use ($request) {
                $q->where('id', $request->input('doctor_id'));
            });
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