<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;

class CertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $user->can('read.certificates');
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Certificate $certificate): bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }
        if ($user->hasRole('doctor') && $user->doctor) {
            return $user->can("read.{$user->doctor->specialty->name}");
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }
        return $user->can('create.certificates');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Certificate $certificate): bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }
        if ($user->hasRole('doctor') && $user->doctor) {
            return $user->can("update.{$user->doctor->specialty->name}");
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Certificate $certificate): bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }
        if ($user->hasRole('doctor') && $user->doctor) {
            return $user->can("delete.{$user->doctor->specialty->name}");
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Certificate $certificate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Certificate $certificate): bool
    {
        return false;
    }
}
