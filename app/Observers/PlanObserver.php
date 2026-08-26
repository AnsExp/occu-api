<?php

namespace App\Observers;

use App\Models\Plan;

class PlanObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Plan $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Plan $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Plan $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Plan $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Plan $model): void
    {
        //
    }
}
