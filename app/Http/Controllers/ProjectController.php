<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all()->sortBy('name');
        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function store(ProjectStoreRequest $request)
    {
        $this->authorize('create', [Project::class]);

        $data = $request->validated();
        $project = Project::create($data);

        return new ProjectResource($project);
    }

    public function update(ProjectStoreRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validated();
        $project->update($data);

        return new ProjectResource($project);
    }
}
