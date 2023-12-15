<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewUserProjects(User $user): bool
    {
        return !$user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {

        $users = $project->users()->get()->toArray();

        $usersIds = array();

        foreach($users as $a_user) {
            array_push($usersIds, $a_user['id']);
        }
        
        return (in_array($user->id, $usersIds)) || $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can see the forum of the model.
     */
    public function viewForum(User $user, Project $project): bool
    {
        return $project->users->contains($user);
    }
}
