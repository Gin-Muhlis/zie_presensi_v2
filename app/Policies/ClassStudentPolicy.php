<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassStudent;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassStudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the classStudent can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list classstudents');
    }

    /**
     * Determine whether the classStudent can view the model.
     */
    public function view(User $user, ClassStudent $model): bool
    {
        return $user->hasPermissionTo('view classstudents');
    }

    /**
     * Determine whether the classStudent can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create classstudents');
    }

    /**
     * Determine whether the classStudent can update the model.
     */
    public function update(User $user, ClassStudent $model): bool
    {
        return $user->hasPermissionTo('update classstudents');
    }

    /**
     * Determine whether the classStudent can delete the model.
     */
    public function delete(User $user, ClassStudent $model): bool
    {
        return $user->hasPermissionTo('delete classstudents');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete classstudents');
    }

    /**
     * Determine whether the classStudent can restore the model.
     */
    public function restore(User $user, ClassStudent $model): bool
    {
        return false;
    }

    /**
     * Determine whether the classStudent can permanently delete the model.
     */
    public function forceDelete(User $user, ClassStudent $model): bool
    {
        return false;
    }
}
