<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentAbsence;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentAbsencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the studentAbsence can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list studentabsences');
    }

    /**
     * Determine whether the studentAbsence can view the model.
     */
    public function view(User $user, StudentAbsence $model): bool
    {
        return $user->hasPermissionTo('view studentabsences');
    }

    /**
     * Determine whether the studentAbsence can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create studentabsences');
    }

    /**
     * Determine whether the studentAbsence can update the model.
     */
    public function update(User $user, StudentAbsence $model): bool
    {
        return $user->hasPermissionTo('update studentabsences');
    }

    /**
     * Determine whether the studentAbsence can delete the model.
     */
    public function delete(User $user, StudentAbsence $model): bool
    {
        return $user->hasPermissionTo('delete studentabsences');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete studentabsences');
    }

    /**
     * Determine whether the studentAbsence can restore the model.
     */
    public function restore(User $user, StudentAbsence $model): bool
    {
        return false;
    }

    /**
     * Determine whether the studentAbsence can permanently delete the model.
     */
    public function forceDelete(User $user, StudentAbsence $model): bool
    {
        return false;
    }
}
