<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        return $project->users->contains($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $post->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $post->user_id == $user->id || $post->project->coordinator->id == $user->id || $user->is_admin;
    }

}
