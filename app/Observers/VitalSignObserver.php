<?php

namespace App\Observers;

use App\Models\VitalSign;

class VitalSignObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(VitalSign $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(VitalSign $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(VitalSign $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(VitalSign $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(VitalSign $model): void
    {
        //
    }
}
