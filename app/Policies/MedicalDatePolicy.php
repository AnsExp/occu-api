<?php

namespace App\Policies;

use App\Models\MedicalDate;
use App\Models\User;

class MedicalDatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read.medical_dates');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MedicalDate $medicalDate): bool
    {
        return $user->can('read.medical_dates');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.medical_dates');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MedicalDate $medicalDate): bool
    {
        return $user->can('update.medical_dates');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MedicalDate $medicalDate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MedicalDate $medicalDate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedicalDate $medicalDate): bool
    {
        return false;
    }
}
