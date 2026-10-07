<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CollectionService;
use App\Http\Requests\StoreCollectionRequest;

class CollectionController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $collections = $project->collections;
        return view('collections.index', compact('project', 'collections'));
    }

    public function create(Project $project)
    {
        $this->authorize('manage', $project);
        return view('collections.create', compact('project'));
    }

    public function store(StoreCollectionRequest $request, Project $project, CollectionService $service)
    {
        $this->authorize('manage', $project);
        $collection = $service->create($project, $request->validated());
        return redirect()->route('projects.collections.index', $project)->with('message', 'وصول با موفقیت ثبت شد');
    }
}
