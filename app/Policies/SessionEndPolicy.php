<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SessionEnd;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionEndPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sessionEnd can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sessionends');
    }

    /**
     * Determine whether the sessionEnd can view the model.
     */
    public function view(User $user, SessionEnd $model): bool
    {
        return $user->hasPermissionTo('view sessionends');
    }

    /**
     * Determine whether the sessionEnd can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sessionends');
    }

    /**
     * Determine whether the sessionEnd can update the model.
     */
    public function update(User $user, SessionEnd $model): bool
    {
        return $user->hasPermissionTo('update sessionends');
    }

    /**
     * Determine whether the sessionEnd can delete the model.
     */
    public function delete(User $user, SessionEnd $model): bool
    {
        return $user->hasPermissionTo('delete sessionends');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sessionends');
    }

    /**
     * Determine whether the sessionEnd can restore the model.
     */
    public function restore(User $user, SessionEnd $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sessionEnd can permanently delete the model.
     */
    public function forceDelete(User $user, SessionEnd $model): bool
    {
        return false;
    }
}
