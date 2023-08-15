<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the teacher can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list teachers');
    }

    /**
     * Determine whether the teacher can view the model.
     */
    public function view(User $user, Teacher $model): bool
    {
        return $user->hasPermissionTo('view teachers');
    }

    /**
     * Determine whether the teacher can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create teachers');
    }

    /**
     * Determine whether the teacher can update the model.
     */
    public function update(User $user, Teacher $model): bool
    {
        return $user->hasPermissionTo('update teachers');
    }

    /**
     * Determine whether the teacher can delete the model.
     */
    public function delete(User $user, Teacher $model): bool
    {
        return $user->hasPermissionTo('delete teachers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete teachers');
    }

    /**
     * Determine whether the teacher can restore the model.
     */
    public function restore(User $user, Teacher $model): bool
    {
        return false;
    }

    /**
     * Determine whether the teacher can permanently delete the model.
     */
    public function forceDelete(User $user, Teacher $model): bool
    {
        return false;
    }
}
