<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCost;
use App\Services\CostControlService;
use App\Http\Requests\StoreCostRequest;

class CostController extends Controller
{
    public function index()
    {
        $costs = ProjectCost::with('project')->get();
        return response()->json($costs);
    }

    public function show(ProjectCost $cost)
    {
        return response()->json($cost);
    }

    public function store(StoreCostRequest $request, CostControlService $service)
    {
        $validated = $request->validated();
        $project = Project::findOrFail($validated['project_id']);
        $cost = $service->create($project, $validated);
        return response()->json($cost, 201);
    }
}
