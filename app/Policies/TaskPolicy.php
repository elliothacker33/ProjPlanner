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
        if ($user->is_admin) return true;

        $users = $task->project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
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

    public function changeStatus(User $user, Task $task): bool
    {
        return $task->project->user_id == $user->id || $task->assigned->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return ($task->project->coordinator === $user);
    }

    /**
     * Determine whether the user can assign someone to the model. 
     */
    public function assign(User $user, Task $task): bool
    {
        $users = $task->project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;;
    }

    /**
     * Determine whether the user can comment on the model.
     */
    public function comment(User $user, Task $task): bool
    {
        $users = $task->project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }




}
