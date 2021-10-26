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

    public function update(User $user, $projectId)
    {
        Project::where('id', $projectId)->firstOrfail();
        return $user->can('add project') ? true : false;
    }
}
