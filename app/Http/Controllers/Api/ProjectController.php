<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index(ProjectService $service)
    {
        $projects = $service->getAll(request()->all());
        return response()->json($projects);
    }

    public function show(Project $project)
    {
        return response()->json($project);
    }

    public function store(StoreProjectRequest $request, ProjectService $service)
    {
        $project = $service->create($request->validated());
        return response()->json($project, 201);
    }

    public function update(UpdateProjectRequest $request, Project $project, ProjectService $service)
    {
        $service->update($project, $request->validated());
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}
