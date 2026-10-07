<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Forecast;
use App\Services\ForecastService;
use App\Http\Requests\StoreForecastRequest;

class ForecastController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $forecasts = $project->forecasts;
        return view('forecasts.index', compact('project', 'forecasts'));
    }

    public function store(StoreForecastRequest $request, Project $project, ForecastService $service)
    {
        $this->authorize('update', $project);
        $forecast = $service->create($project, $request->validated());
        return redirect()->route('projects.forecasts.index', $project)->with('message', 'پیش‌بینی با موفقیت ثبت شد');
    }

    public function show(Project $project, Forecast $forecast)
    {
        $this->authorize('view', $project);
        return view('forecasts.show', compact('project', 'forecast'));
    }
}
