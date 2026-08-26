<?php

namespace App\Observers;

use App\Models\Doctor;

class DoctorObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Doctor $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Doctor $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Doctor $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Doctor $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Doctor $model): void
    {
        //
    }
}
