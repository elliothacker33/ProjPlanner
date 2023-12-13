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

        foreach ($users as $a_user) {
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
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can archive the model.
     */
    public function archive(User $user, Project $project): bool
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can leave the model.
     */
    public function leave(User $user, Project $project): bool
    {
        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can show the team of the model.
     */
    public function show_team(User $user, Project $project): bool
    {

        if ($user->is_admin) return true;

        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the forum of the model.
     */
    public function view_forum(User $user, Project $project): bool
    {

        if ($user->is_admin) return true;

        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can add a member to the model.
     */
    public function add_member(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can remove a member from the model.
     */
    public function remove_member(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can assign a new coordinator to the model.
     */
    public function assign_coordinator(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

}
