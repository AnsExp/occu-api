<?php

namespace App\Observers;

use App\Models\Specialty;

class SpecialtyObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Specialty $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Specialty $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Specialty $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Specialty $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Specialty $model): void
    {
        //
    }
}
