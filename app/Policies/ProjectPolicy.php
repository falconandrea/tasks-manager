<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('add project') ? true : false;
    }

    public function update(User $user, Project $project)
    {
        return $user->can('add project') ? true : false;
    }
}
