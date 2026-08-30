<?php

namespace App\Http\Filters;

use App\Models\PersonalData;

class PersonalDataFilter
{
    public function query(array $params)
    {
        $query = PersonalData::query();

        if (isset($params['first_name'])) {
            $query->where('first_name', 'like', "%{$params['first_name']}%");
        }

        if (isset($params['last_name'])) {
            $query->where('last_name', 'like', "%{$params['last_name']}%");
        }

        if (isset($params['phone'])) {
            $query->where('phone', 'like', "%{$params['phone']}%");
        }

        if (isset($params['id_card'])) {
            $query->where('id_card', 'like', "%{$params['id_card']}%");
        }

        if (isset($params['gender'])) {
            $query->where('gender', $params['gender']);
        }

        if (isset($params['birth_date'])) {
            $query->where('birth_date', $params['birth_date']);
        } else if (isset($params['birth_date_min']) && isset($params['birth_date_max'])) {
            $query->whereBetween('birth_date', [$params['birth_date_min'], $params['birth_date_max']]);
        } else if (isset($params['birth_date_min'])) {
            $query->where('birth_date', '>=', $params['birth_date_min']);
        } else if (isset($params['birth_date_max'])) {
            $query->where('birth_date', '<=', $params['birth_date_max']);
        }

        if (isset($params['nationality'])) {
            $query->where('nationality', 'like', "%{$params['nationality']}%");
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