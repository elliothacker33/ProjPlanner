<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Post;

class PostPolicy
{
    
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        
        if ($user->is_admin) return true;

        $members = $post->project()->get()->toArray();
        
        foreach ($members as $member) {
            if ($member['id'] == $user->id) return true;
        }

        return false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        $members = $project->members()->get()->toArray();

        foreach ($members as $member) {
            if ($member['id'] == $user->id) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author->id;
    }

}
