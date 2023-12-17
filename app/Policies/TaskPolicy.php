<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->is_admin || $task->project->users()->contains($user);
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
     * Determine whether the user can comment on the model.
     */
    public function comment(User $user, Task $task): bool
    {
        return $task->project->users()->contains($user);
    }




}
