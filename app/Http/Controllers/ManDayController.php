<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectManDay;
use App\Services\ManDayService;
use App\Http\Requests\StoreManDayRequest;
use App\Http\Requests\UpdateManDayRequest;

class ManDayController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $records = $project->manDays;
        return view('man-days.index', compact('project', 'records'));
    }

    public function store(StoreManDayRequest $request, Project $project, ManDayService $service)
    {
        $this->authorize('update', $project);
        $manDay = $service->create($project, $request->validated());
        return redirect()->route('projects.man-days.index', $project)->with('message', 'روزهای کار با موفقیت ثبت شد');
    }

    public function update(UpdateManDayRequest $request, Project $project, ProjectManDay $manDay, ManDayService $service)
    {
        $this->authorize('update', $project);
        $service->update($manDay, $request->validated());
        return redirect()->route('projects.man-days.index', $project)->with('message', 'روزهای کار به‌روزرسانی شد');
    }
}
