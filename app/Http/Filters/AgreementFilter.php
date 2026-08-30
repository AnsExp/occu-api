<?php

namespace App\Http\Filters;

use App\Models\Agreement;

class AgreementFilter
{
    public function query(array $params)
    {
        $query = Agreement::query();

        if (isset($params['institution'])) {
            $query->where('institution', 'like', '%' . $params['institution'] . '%');
        }

        if (isset($params['discount_type'])) {
            $query->where('discount_type', $params['discount_type']);
        }

        if (isset($params['discount_amount'])) {
            $query->where('discount_amount', $params['discount_amount']);
        } else if (isset($params['discount_amount_max']) && isset($params['discount_amount_min'])) {
            $query->whereBetween('discount_amount', [$params['discount_amount_min'], $params['discount_amount_max']]);
        } else if (isset($params['discount_amount_max'])) {
            $query->where('discount_amount', '<=', $params['discount_amount_max']);
        } else if (isset($params['discount_amount_min'])) {
            $query->where('discount_amount', '>=', $params['discount_amount_min']);
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