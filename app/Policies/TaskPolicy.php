<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

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
        return ($task->project->user_id == $user->id || $task->assigned->contains($user)) && $task->status == 'open';
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
    public function apiUpdate(User $authUser, User $actionUser, Project $project, Task $task)
    {   
        if (!($actionUser->id == $project->user_id || $task->assigned->contains($actionUser)))
            return Response::denyWithStatus(403);
        else if ($task->status != 'open')
            return Response::denyWithStatus(409);

        return Response::allow();
    }
}
