<?php

namespace App\Observers;

use App\Models\MedicalDateRelationship;

class MedicalDateRelationshipObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(MedicalDateRelationship $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(MedicalDateRelationship $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(MedicalDateRelationship $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(MedicalDateRelationship $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(MedicalDateRelationship $model): void
    {
        //
    }
}
