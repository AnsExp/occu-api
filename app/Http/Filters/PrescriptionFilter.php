<?php

namespace App\Http\Filters;

use App\Models\Prescription;

class PrescriptionFilter extends Filter
{
    public function query(array $params)
    {
        $query = Prescription::query();

        if (isset($params['patient_id_card'])) {
            $query->whereHas('patient.person', function ($q) use ($params) {
                $q->where('id_card', $params['patient_id_card']);
            });
        }

        if (isset($params['patient_first_name'])) {
            $query->whereHas('patient.person', function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['patient_first_name']}%");
            });
        }

        if (isset($params['patient_last_name'])) {
            $query->whereHas('patient.person', function ($q) use ($params) {
                $q->where('last_name', 'like', "%{$params['patient_last_name']}%");
            });
        }

        if (isset($params['doctor_id_card'])) {
            $query->whereHas('doctor.person', function ($q) use ($params) {
                $q->where('id_card', $params['doctor_id_card']);
            });
        }

        if (isset($params['doctor_first_name'])) {
            $query->whereHas('doctor.person', function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['doctor_first_name']}%");
            });
        }

        if (isset($params['doctor_last_name'])) {
            $query->whereHas('doctor.person', function ($q) use ($params) {
                $q->where('last_name', 'like', "%{$params['doctor_last_name']}%");
            });
        }

        if (isset($params['timezone'])) {
            $query->where('timezone', $params['timezone']);
        }

        if (isset($params['order_by'])) {
            $orderBy = $params['order_by'];
            $order = $params['order'] ?? 'asc';
            $query->orderBy($orderBy, $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }
}