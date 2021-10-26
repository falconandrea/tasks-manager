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

    public function update(User $user, $taskId)
    {
        Task::where('id', $taskId)->firstOrfail();
        return $user->can('add task') ? true : false;
    }

    public function status(User $user, $taskId)
    {
        Task::where('id', $taskId)->firstOrfail();
        return $user->can('change task status') ? true : false;
    }

    public function asign(User $user, $taskId)
    {
        Task::where('id', $taskId)->firstOrfail();
        return $user->can('assign task') ? true : false;
    }
}
