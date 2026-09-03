<?php

namespace App\Http\Filters;

use App\Models\Medication;

class MedicationFilter extends Filter
{
    public function query(array $params)
    {
        $query = Medication::query();

        if (isset($params['name'])) {
            $query->where('name', 'like', "%{$params['name']}%");
        }

        if (isset($params['price'])) {
            $query->where('price', $params['price']);
        } else if (isset($params['price_min']) && isset($params['price_max'])) {
            $query->whereBetween('price', [$params['price_min'], $params['price_max']]);
        } else if (isset($params['price_min'])) {
            $query->where('price', '>=', $params['price_min']);
        } else if (isset($params['price_max'])) {
            $query->where('price', '<=', $params['price_max']);
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