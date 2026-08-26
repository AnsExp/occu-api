<?php

namespace App\Observers;

use App\Models\Agreement;

class AgreementObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Agreement $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Agreement $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Agreement $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Agreement $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Agreement $model): void
    {
        //
    }
}
