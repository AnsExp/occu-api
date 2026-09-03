<?php

namespace App\Http\Filters;

use App\Models\VitalSign;

class VitalSignFilter extends Filter
{
    public function query(array $params)
    {
        $query = VitalSign::query();

        if (isset($params['patient_id'])) {
            $query->where('patient_id', $params['patient_id']);
        }

        if (isset($params['medical_date_id'])) {
            $query->where('medical_date_id', $params['medical_date_id']);
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