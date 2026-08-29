<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait HasAuditLog
{
    private function logAction(Model $model, string $action)
    {
        $request = request();

        AuditLog::create([
            'table' => $model->getTable(),
            'record_id' => $model->getKey(),
            'action' => $action,
            'changes' => $model->getChanges(),
            'user_id' => auth()->id(),
            // 'user_id' => auth()->check() ? auth()->id() : null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}