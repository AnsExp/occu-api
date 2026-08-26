<?php

namespace App\Observers;

use App\Models\MedicalDate;

class MedicalDateObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(MedicalDate $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(MedicalDate $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(MedicalDate $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(MedicalDate $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(MedicalDate $model): void
    {
        //
    }
}
