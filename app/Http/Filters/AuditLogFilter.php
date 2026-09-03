<?php

namespace App\Http\Filters;

use App\Models\AuditLog;

class AuditLogFilter extends Filter
{
    public function query(array $params)
    {
        $query = AuditLog::query();

        if (isset($params['table'])) {
            $query->where('table', $params['table']);
            if (isset($params['record_id'])) {
                $query->where('record_id', $params['record_id']);
            }
        }

        if (isset($params['action'])) {
            $query->where('action', $params['action']);
        }

        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }

        if (isset($params['ip_address'])) {
            $query->where('ip_address', $params['ip_address']);
        }

        if (isset($params['created_at'])) {
            $query->where('created_at', $params['created_at']);
        } else if (isset($params['created_at_from']) && isset($params['created_at_to'])) {
            $query->whereBetween('created_at', [$params['created_at_from'], $params['created_at_to']]);
        } else if (isset($params['created_at_from'])) {
            $query->where('created_at', '>=', $params['created_at_from']);
        } else if (isset($params['created_at_to'])) {
            $query->where('created_at', '<=', $params['created_at_to']);
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