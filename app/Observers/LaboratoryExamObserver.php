<?php

namespace App\Observers;

use App\Models\LaboratoryExam;

class LaboratoryExamObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(LaboratoryExam $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(LaboratoryExam $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(LaboratoryExam $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(LaboratoryExam $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(LaboratoryExam $model): void
    {
        //
    }
}
