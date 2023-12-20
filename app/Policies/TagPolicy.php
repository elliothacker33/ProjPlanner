<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tag;
use App\Models\Project;
use App\Models\Task;

class TagPolicy
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
    public function update(User $user, Tag $tag, Project $project): bool
    {
        return $project->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag, Project $project): bool
    {
        return $project->users->contains($user);
    }
}