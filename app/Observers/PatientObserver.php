<?php

namespace App\Observers;

use App\Models\Patient;

class PatientObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Patient $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Patient $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Patient $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Patient $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Patient $model): void
    {
        //
    }
}
