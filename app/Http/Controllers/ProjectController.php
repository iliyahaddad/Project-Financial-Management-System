<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index(ProjectService $service)
    {
        $projects = $service->getAll(request()->all());
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request, ProjectService $service)
    {
        $this->authorize('create', Project::class);
        $project = $service->create($request->validated());
        return redirect()->route('projects.show', $project)->with('message', 'پروژه با موفقیت ایجاد شد');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project, ProjectService $service)
    {
        $this->authorize('update', $project);
        $service->update($project, $request->validated());
        return redirect()->route('projects.show', $project)->with('message', 'پروژه به‌روزرسانی شد');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('message', 'پروژه حذف شد');
    }
}
