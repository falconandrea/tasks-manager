<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('add task') ? true : false;
    }

    public function show(User $user, Task $task)
    {
        // Developer can see only his tasks
        if ($user->hasRole('developer') && $task->user->id != $user->id) {
            return false;
        }
        return true;
    }

    public function update(User $user)
    {
        return $user->can('add task');
    }

    public function status(User $user, Task $task)
    {
        // Developer can see only his tasks
        if ($user->hasRole('developer') && $task->user->id != $user->id) {
            return false;
        }
        return $user->can('change task status') ? true : false;
    }

    public function assign(User $user, Task $task)
    {
        return $user->can('assign task') ? true : false;
    }
}
