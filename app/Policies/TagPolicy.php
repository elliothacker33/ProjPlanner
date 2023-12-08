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
        $members = $project->users()->get()->toArray();

        foreach ($members as $member) {
            if ($member['id'] === $user->id) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag, Project $project): bool
    {
        $members = $project->users()->get()->toArray();

        foreach ($members as $member) {
            if ($member['id'] === $user->id) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag, Project $project): bool
    {
        $members = $project->users()->get()->toArray();

        foreach ($members as $member) {
            if ($member['id'] === $user->id) return true;
        }

        return false;
    }
}
