<?php

namespace App\Http\Filters;

use App\Models\LaboratoryOption;

class LaboratoryOptionFilter extends Filter
{
    public function query(array $params)
    {
        $query = LaboratoryOption::query();

        if (isset($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (isset($params['code'])) {
            $query->where('code', 'like', '%' . $params['code'] . '%');
        }

        if (isset($params['price'])) {
            $query->where('price', $params['price']);
        } else if (isset($params['price_max']) && isset($params['price_min'])) {
            $query->whereBetween('price', [$params['price_min'], $params['price_max']]);
        } else if (isset($params['price_max'])) {
            $query->where('price', '<=', $params['price_max']);
        } else if (isset($params['price_min'])) {
            $query->where('price', '>=', $params['price_min']);
        }

        if (isset($params['order_by'])) {
            $orderBy = $params['order_by'];
            $order = $params['order'] ?? 'asc';
        } else {
            $orderBy = 'created_at';
            $order = 'asc';
        }
        $query->orderBy($orderBy, $order);

        return $query;
    }
}