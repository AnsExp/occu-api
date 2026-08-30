<?php

namespace App\Http\Filters;

use App\Models\LaboratoryOrder;

class LaboratoryOrderFilter
{
    public function query(array $params)
    {
        $query = LaboratoryOrder::query();

        if (isset($params['patient_id_card'])) {
            $query->whereHas('patient.personalData', function ($q) use ($params) {
                $q->where('id_card', $params['patient_id_card']);
            });
        }

        if (isset($params['patient_id'])) {
            $query->whereHas('patient.personalData', function ($q) use ($params) {
                $q->where('id', $params['patient_id']);
            });
        }

        if (isset($params['doctor_id_card'])) {
            $query->whereHas('doctor.personalData', function ($q) use ($params) {
                $q->where('id_card', $params['doctor_id_card']);
            });
        }

        if (isset($params['doctor_id'])) {
            $query->whereHas('doctor.personalData', function ($q) use ($params) {
                $q->where('id', $params['doctor_id']);
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