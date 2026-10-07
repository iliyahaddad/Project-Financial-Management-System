<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Services\ProgressService;
use App\Http\Requests\StoreProgressRequest;
use App\Http\Requests\UpdateProgressRequest;

class ProgressController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $records = $project->progresses;
        return view('progress.index', compact('project', 'records'));
    }

    public function store(StoreProgressRequest $request, Project $project, ProgressService $service)
    {
        $this->authorize('update', $project);
        $progress = $service->create($project, $request->validated());
        return redirect()->route('projects.progress.index', $project)->with('message', 'پیشرفت با موفقیت ثبت شد');
    }

    public function update(UpdateProgressRequest $request, Project $project, ProjectProgress $progress, ProgressService $service)
    {
        $this->authorize('update', $project);
        $service->update($progress, $request->validated());
        return redirect()->route('projects.progress.index', $project)->with('message', 'پیشرفت به‌روزرسانی شد');
    }
}
