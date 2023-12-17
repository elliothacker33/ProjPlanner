<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $user_profile): bool
    {
        return $user->is_admin || ($user_profile->id===$user->id && !$user_profile->is_blocked);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $model == $user || $user->is_admin;
    }

    /**
     * Determine whether the user can create admins.
     */
    public function create_admin(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view admins.
     */
    public function view_admin(User $user): bool
    {
        return $user->is_admin;
    }
    
    /**
     * Determine whether the user can block users.
     */
    public function block(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can unblock users.
     */
    public function unblock(User $user): bool
    {
       return $user->is_admin;
    }

    

}
