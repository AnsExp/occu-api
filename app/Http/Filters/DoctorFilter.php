<?php

namespace App\Http\Filters;

use App\Models\Doctor;

class DoctorFilter
{
    public function query(array $params): \Illuminate\Database\Eloquent\Builder
    {
        $query = Doctor::query();

        if (isset($params['is_occupational_doctor'])) {
            $query->where('is_occupational_doctor', filter_var($params['is_occupational_doctor'], FILTER_VALIDATE_BOOLEAN));
        }

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

        if (isset($params['specialty_id'])) {
            $query->where('specialty_id', $params['specialty_id']);
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