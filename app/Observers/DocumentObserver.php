<?php

namespace App\Observers;

use App\Models\Document;

class DocumentObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(Document $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Document $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Document $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(Document $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(Document $model): void
    {
        //
    }
}
