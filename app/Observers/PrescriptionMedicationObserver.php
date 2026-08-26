<?php

namespace App\Observers;

use App\Models\PrescriptionMedication;

class PrescriptionMedicationObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(PrescriptionMedication $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(PrescriptionMedication $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(PrescriptionMedication $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(PrescriptionMedication $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(PrescriptionMedication $model): void
    {
        //
    }
}
