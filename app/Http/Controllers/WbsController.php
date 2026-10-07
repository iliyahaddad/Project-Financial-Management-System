<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Wbs;
use App\Services\WbsService;
use App\Http\Requests\StoreWbsRequest;
use App\Http\Requests\UpdateWbsRequest;

class WbsController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $wbss = $project->wbs;
        return view('wbs.index', compact('project', 'wbss'));
    }

    public function store(StoreWbsRequest $request, Project $project, WbsService $service)
    {
        $this->authorize('update', $project);
        $wbs = $service->create($project, $request->validated());
        return redirect()->route('projects.wbs.index', $project)->with('message', 'فعالیت با موفقیت ایجاد شد');
    }

    public function update(UpdateWbsRequest $request, Project $project, Wbs $wbs, WbsService $service)
    {
        $this->authorize('update', $project);
        $service->update($wbs, $request->validated());
        return redirect()->route('projects.wbs.index', $project)->with('message', 'فعالیت به‌روزرسانی شد');
    }

    public function destroy(Project $project, Wbs $wbs)
    {
        $this->authorize('update', $project);
        $wbs->delete();
        return redirect()->route('projects.wbs.index', $project)->with('message', 'فعالیت حذف شد');
    }
}
