<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;


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
        return $project->users->contains($user) || $user->is_admin;
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
        return ($user->id === $project->user_id && !$project->is_archived);
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
        return $user->id == $project->user_id && !$project->is_archived;
    }
    
    /**
     * Determine whether the user can leave the model.
     */
    public function leave(User $user, Project $project): bool
    {

        if ($user->id === $project->user_id) return false;

        return $project->users->contains($user);
    }

    /**
     * Determine whether the user can show the team of the model.
     */
    public function show_team(User $user, Project $project): bool
    {
        return $project->users->contains($user) || $user->is_admin;
    }

    /**
     * Determine whether the user can view the forum of the model.
     */
    public function view_forum(User $user, Project $project): bool
    {

        return $user->is_admin || $project->users->contains($user);
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

    public function removeUser(User $user, Project $project, User $removedUser): bool
    {
        $leaveProject = $user == $removedUser && $user != $project->coordinator;
        $removeUser = $user == $project->coordinator && $removedUser != $project->coordinator;
        return $project->users->contains($removedUser) && ($leaveProject || $removeUser) && !$project->is_archived;
    }

    public function send_invite(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

}
