<?php

namespace App\Http\Filters;

use App\Models\MedicalDate;

class MedicalDateFilter extends Filter
{
    public function query(array $params)
    {
        $query = MedicalDate::query();

        if (isset($params['date'])) {
            $query->where('date', $params['date']);
        } else if (isset($params['date_min']) && isset($params['date_max'])) {
            $query->whereBetween('date', [$params['date_min'], $params['date_max']]);
        } else if (isset($params['date_min'])) {
            $query->where('date', '>=', $params['date_min']);
        } else if (isset($params['date_max'])) {
            $query->where('date', '<=', $params['date_max']);
        }

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (isset($params['doctor_id'])) {
            $query->where('doctor_id', $params['doctor_id']);
        }

        if (isset($params['specialty_id'])) {
            $query->where('specialty_id', $params['specialty_id']);
        }

        if (isset($params['doctor_id_card'])) {
            $query->whereHas('doctor.personalData', function ($q) use ($params) {
                $q->where('id_card', $params['doctor_id_card']);
            });
        }

        if (isset($params['doctor_first_name'])) {
            $query->whereHas('doctor.personalData', function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['doctor_first_name']}%");
            });
        }

        if (isset($params['doctor_last_name'])) {
            $query->whereHas('doctor.personalData', function ($q) use ($params) {
                $q->where('last_name', 'like', "%{$params['doctor_last_name']}%");
            });
        }

        if (isset($params['patient_id'])) {
            $query->where('patient_id', $params['patient_id']);
        }

        if (isset($params['patient_id_card'])) {
            $query->whereHas('patient.personalData', function ($q) use ($params) {
                $q->where('id_card', $params['patient_id_card']);
            });
        }

        if (isset($params['patient_first_name'])) {
            $query->whereHas('patient.personalData', function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['patient_first_name']}%");
            });
        }

        if (isset($params['patient_last_name'])) {
            $query->whereHas('patient.personalData', function ($q) use ($params) {
                $q->where('last_name', 'like', "%{$params['patient_last_name']}%");
            });
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