<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Customer;
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

        $customer = Customer::where('id', $data['customer'])->first();
        $customer->projects()->create([
            'name' => $data['name']
        ]);
    }
}
