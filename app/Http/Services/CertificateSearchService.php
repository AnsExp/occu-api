<?php

namespace App\Http\Services;

use App\Models\Certificate;

class CertificateSearchService
{
    public function search(string $type)
    {
        $filters = [
            'id_card' => request('id_card', null),
            'order_number' => request('order_number', null),
            'date_start' => request('date_start', null),
            'date_end' => request('date_end', null),
        ];
        $query = Certificate::with('order.patient');
        if ($filters['id_card']) {
            $query->whereHas('order.patient', function ($q) use ($filters) {
                $q->where('id_card', 'like', "%{$filters['id_card']}%");
            });
        }
        if ($filters['order_number']) {
            $query->where('title', 'like', "%{$filters['order_number']}%");
        }
        if ($filters['date_start'] && $filters['date_end']) {
            $query->whereDate('created_at', '>=', $filters['date_start'])
                ->whereDate('created_at', '<=', $filters['date_end']);
        } elseif ($filters['date_start']) {
            $query->whereDate('created_at', '>=', $filters['date_start']);
        } elseif ($filters['date_end']) {
            $query->whereDate('created_at', '<=', $filters['date_end']);
        }
        if ($type) {
            $query->where('type', $type);
        }
        return $query;
    }
}
