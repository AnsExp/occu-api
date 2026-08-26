<?php

namespace App\Observers;

use App\Models\PersonalData;

class PersonalDataObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(PersonalData $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(PersonalData $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(PersonalData $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(PersonalData $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(PersonalData $model): void
    {
        //
    }
}
