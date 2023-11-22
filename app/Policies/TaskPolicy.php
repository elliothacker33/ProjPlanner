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
    public function create(User $user,Project $project): bool
    {
        $users = $project->users()->get()->toArray();

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        $assigned = DB::table('task_user')
            ->where('task_id','=',$task->id)
            ->where('user_id','=', $user->id)->get();
        $coordinator = DB::table('project_user')
            ->join('projects','projects.id','=','project_user.project_id')
            ->join('project_task','project_task.project_id','=','project_user.project_id')
            ->where('task_id','=',$task->id)
            ->where('projects.user_id','=', $user->id)->get();
        if(!$assigned->isEmpty() || !$coordinator->isEmpty()) return true;
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
}
