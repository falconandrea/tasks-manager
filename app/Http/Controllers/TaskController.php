<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskListResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
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

    public function show(Request $request)
    {

        $task = Task::find($request->id);
        if (!$task) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Developer can see only his tasks
        if ($request->user()->hasRole('developer') && $task->user->id != $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return new TaskResource($task);
    }

    public function store(TaskStoreRequest $request)
    {
        $this->authorize('create', [Task::class]);

        $data = $request->validated();

        $data['user_id'] = $data['user'];
        unset($data['user']);

        $project = Project::where('id', $data['project'])->first();
        unset($data['project']);
        $project->tasks()->create($data);
    }
}
