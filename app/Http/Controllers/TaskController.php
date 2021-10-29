<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskAssignRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskListResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::orderBy('updated_at', 'DESC');

        // Developer see only his tasks
        if ($request->user()->hasRole('developer')) {
            $tasks->where('user_id', '=', $request->user()->id);
        }

        return TaskListResource::collection($tasks->get());
    }

    public function show(Task $task)
    {
        $this->authorize('show', $task);

        return new TaskResource($task);
    }

    public function store(TaskStoreRequest $request)
    {
        $this->authorize('create', [Task::class]);

        $data = $request->validated();
        $task = Task::create($data);

        return new TaskResource($task);
    }

    public function update(TaskStoreRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validated();
        $task->update($data);

        return new TaskResource($task);
    }

    public function status(TaskStatusUpdateRequest $request, Task $task)
    {
        $this->authorize('status', $task);

        $data = $request->validated();
        $task->update($data);

        return new TaskResource($task);
    }

    public function assign(TaskAssignRequest $request, Task $task)
    {
        $this->authorize('assign', $task);

        $data = $request->validated();
        $task->update($data);

        return new TaskResource($task);
    }
}
