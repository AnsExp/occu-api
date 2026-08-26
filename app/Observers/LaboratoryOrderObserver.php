<?php

namespace App\Observers;

use App\Models\LaboratoryOrder;

class LaboratoryOrderObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(LaboratoryOrder $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(LaboratoryOrder $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(LaboratoryOrder $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(LaboratoryOrder $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(LaboratoryOrder $model): void
    {
        //
    }
}
