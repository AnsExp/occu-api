<?php

namespace App\Http\Filters;

use App\Models\Patient;

class PatientFilter
{
    public function query(array $params)
    {
        $query = Patient::query();

        if (isset($params['id_card'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('id_card', $params['id_card']);
            });
        }

        if (isset($params['first_name'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['first_name']}%");
            });
        }

        if (isset($params['last_name'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('last_name', 'like', "%{$params['last_name']}%");
            });
        }

        if (isset($params['agreement_id'])) {
            $query->where('agreement_id', $params['agreement_id']);
        }

        if (isset($params['birth_date'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('birth_date', $params['birth_date']);
            });
        } else if (isset($params['birth_date_min']) && isset($params['birth_date_max'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->whereBetween('birth_date', [$params['birth_date_min'], $params['birth_date_max']]);
            });
        } else if (isset($params['birth_date_min'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('birth_date', '>=', $params['birth_date_min']);
            });
        } else if (isset($params['birth_date_max'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('birth_date', '<=', $params['birth_date_max']);
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