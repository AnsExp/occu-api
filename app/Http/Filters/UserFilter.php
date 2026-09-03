<?php

namespace App\Http\Filters;

use App\Models\User;

class UserFilter extends Filter
{
    public function query(array $params)
    {
        $query = User::query();

        if (isset($params['name'])) {
            $query->where('name', 'like', "%{$params['name']}%");
        }

        if (isset($params['email'])) {
            $query->where('email', 'like', "%{$params['email']}%");
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