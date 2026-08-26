<?php

namespace App\Observers;

use App\Models\AgreementRequirement;

class AgreementRequirementObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(AgreementRequirement $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(AgreementRequirement $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(AgreementRequirement $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(AgreementRequirement $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(AgreementRequirement $model): void
    {
        //
    }
}
