<?php

namespace App\Http\Filters;

use App\Models\AllowedIp;

class AllowedIpFilter extends Filter
{
    public function query(array $params)
    {
        $query = AllowedIp::query();

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