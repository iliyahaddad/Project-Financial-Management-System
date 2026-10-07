<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCost;
use App\Services\CostControlService;
use App\Http\Requests\StoreCostRequest;
use App\Http\Requests\UpdateCostRequest;

class CostController extends Controller
{
    public function index()
    {
        $costs = ProjectCost::with('project')->paginate(config('mali.pagination_per_page', 15));
        return view('costs.index', compact('costs'));
    }

    public function create()
    {
        return view('costs.create');
    }

    public function store(StoreCostRequest $request, CostControlService $service)
    {
        $validated = $request->validated();
        $project = Project::findOrFail($validated['project_id']);
        $cost = $service->create($project, $validated);
        return redirect()->route('costs.index')->with('message', 'هزینه با موفقیت ثبت شد');
    }

    public function edit(ProjectCost $cost)
    {
        $this->authorize('update', $cost->project);
        return view('costs.edit', compact('cost'));
    }

    public function update(UpdateCostRequest $request, ProjectCost $cost, CostControlService $service)
    {
        $this->authorize('update', $cost->project);
        $service->update($cost, $request->validated());
        return redirect()->route('costs.index')->with('message', 'هزینه به‌روزرسانی شد');
    }

    public function destroy(ProjectCost $cost)
    {
        $this->authorize('delete', $cost->project);
        $cost->delete();
        return redirect()->route('costs.index')->with('message', 'هزینه حذف شد');
    }
}
