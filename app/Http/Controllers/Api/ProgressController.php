<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Services\ProgressService;
use App\Http\Requests\StoreProgressRequest;

class ProgressController extends Controller
{
    public function index(Project $project)
    {
        $records = $project->progresses;
        return response()->json($records);
    }

    public function show(Project $project, ProjectProgress $progress)
    {
        return response()->json($progress);
    }

    public function store(StoreProgressRequest $request, Project $project, ProgressService $service)
    {
        $progress = $service->create($project, $request->validated());
        return response()->json($progress, 201);
    }
}
