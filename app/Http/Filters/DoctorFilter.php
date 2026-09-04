<?php

namespace App\Http\Filters;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorFilter extends Filter
{
    public function query(array $params)
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

        if (isset($params['gender'])) {
            $query->whereHas('personalData', function ($q) use ($params) {
                $q->where('gender', $params['gender']);
            });
        }

        return $this->orderBy($query, $params['order_by'] ?? 'created_at', $params['order'] ?? 'asc');
    }

    private function orderBy(Builder $query, string $orderBy = 'created_at', string $order = 'asc')
    {
        if (
            !in_array($orderBy, [
                'is_occupational_doctor',
                'id_card',
                'first_name',
                'last_name',
                'specialty_name',
                'gender',
                'created_at',
            ])
        ) {
            $orderBy = 'created_at';
        }

        if ($order !== 'asc' && $order !== 'desc') {
            $order = 'asc';
        }

        if ($orderBy === 'first_name') {
            $query->whereHas('personalData', function ($q) use ($order) {
                $q->orderBy('first_name', $order);
            });
        }

        if ($orderBy === 'last_name') {
            $query->whereHas('personalData', function ($q) use ($order) {
                $q->orderBy('last_name', $order);
            });
        }

        if ($orderBy === 'specialty_name') {
            $query->whereHas('specialty', function ($q) use ($order) {
                $q->orderBy('name', $order);
            });
        }

        return $query;
    }
}