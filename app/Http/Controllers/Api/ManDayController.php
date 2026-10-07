<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectManDay;
use App\Services\ManDayService;
use App\Http\Requests\StoreManDayRequest;

class ManDayController extends Controller
{
    public function index(Project $project)
    {
        $records = $project->manDays;
        return response()->json($records);
    }

    public function show(Project $project, ProjectManDay $manDay)
    {
        return response()->json($manDay);
    }

    public function store(StoreManDayRequest $request, Project $project, ManDayService $service)
    {
        $manDay = $service->create($project, $request->validated());
        return response()->json($manDay, 201);
    }
}
