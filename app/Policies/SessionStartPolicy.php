<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SessionStart;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionStartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sessionStart can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list sessionstarts');
    }

    /**
     * Determine whether the sessionStart can view the model.
     */
    public function view(User $user, SessionStart $model): bool
    {
        return $user->hasPermissionTo('view sessionstarts');
    }

    /**
     * Determine whether the sessionStart can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create sessionstarts');
    }

    /**
     * Determine whether the sessionStart can update the model.
     */
    public function update(User $user, SessionStart $model): bool
    {
        return $user->hasPermissionTo('update sessionstarts');
    }

    /**
     * Determine whether the sessionStart can delete the model.
     */
    public function delete(User $user, SessionStart $model): bool
    {
        return $user->hasPermissionTo('delete sessionstarts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete sessionstarts');
    }

    /**
     * Determine whether the sessionStart can restore the model.
     */
    public function restore(User $user, SessionStart $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sessionStart can permanently delete the model.
     */
    public function forceDelete(User $user, SessionStart $model): bool
    {
        return false;
    }
}
