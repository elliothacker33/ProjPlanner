<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project)
    {
        return !$user->isAdmin and $project->users->contains($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        $coordinator = $task->project->user_id;

        $assigned = $task->assigned;

        if ($assigned != null && $coordinator != null) return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can close a specific task
     */
    public function closeAndCancel(User $authUser, User $actionUser, Project $project, Task $task): bool
    {
        return ($actionUser->id == $project->user_id || $task->assigned->contains($actionUser)) && $task->status == 'open';
    }
}
