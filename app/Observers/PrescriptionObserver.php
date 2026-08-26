<?php

namespace App\Observers;

use App\Models\Prescription;

class PrescriptionObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Prescription $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Prescription $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Prescription $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Prescription $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Prescription $model): void
    {
        //
    }
}
