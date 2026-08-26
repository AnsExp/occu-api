<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    use HasAuditLog;

    /**
     * Handle the "created" event.
     */
    public function created(User $model): void
    {
        $this->logAction($model, 'created');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(User $model): void
    {
        $this->logAction($model, 'updated');
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(User $model): void
    {
        $this->logAction($model, 'deleted');
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(User $model): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     */
    public function forceDeleted(User $model): void
    {
        //
    }
}
