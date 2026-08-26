<?php

namespace App\Observers;

use App\Models\LaboratoryOption;

class LaboratoryOptionObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(LaboratoryOption $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(LaboratoryOption $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(LaboratoryOption $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(LaboratoryOption $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(LaboratoryOption $model): void
    {
        //
    }
}
