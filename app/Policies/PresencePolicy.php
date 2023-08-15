<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Presence;
use Illuminate\Auth\Access\HandlesAuthorization;

class PresencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the presence can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list presences');
    }

    /**
     * Determine whether the presence can view the model.
     */
    public function view(User $user, Presence $model): bool
    {
        return $user->hasPermissionTo('view presences');
    }

    /**
     * Determine whether the presence can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create presences');
    }

    /**
     * Determine whether the presence can update the model.
     */
    public function update(User $user, Presence $model): bool
    {
        return $user->hasPermissionTo('update presences');
    }

    /**
     * Determine whether the presence can delete the model.
     */
    public function delete(User $user, Presence $model): bool
    {
        return $user->hasPermissionTo('delete presences');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete presences');
    }

    /**
     * Determine whether the presence can restore the model.
     */
    public function restore(User $user, Presence $model): bool
    {
        return false;
    }

    /**
     * Determine whether the presence can permanently delete the model.
     */
    public function forceDelete(User $user, Presence $model): bool
    {
        return false;
    }
}
