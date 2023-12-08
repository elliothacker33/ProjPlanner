<?php

namespace App\Policies;



use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;


class TaskPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        if ($user->is_admin) return true;

        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        
        $users = $project->users()->get()->toArray();

        foreach ($users as $user_) {
            if ($user->id === $user_['id']) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return ($task->project->coordinator->id === $user->id);
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

    /**
     * Determine whether the user can change the status of the model.
     */
    public function changeStatus(User $user, Task $task): bool
    {
        return $user->id === $task->project->coordinator->id;
    }



}
