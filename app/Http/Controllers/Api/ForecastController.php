<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Forecast;
use App\Services\ForecastService;
use App\Http\Requests\StoreForecastRequest;

class ForecastController extends Controller
{
    public function index(Project $project)
    {
        $forecasts = $project->forecasts;
        return response()->json($forecasts);
    }

    public function show(Project $project, Forecast $forecast)
    {
        return response()->json($forecast);
    }

    public function store(StoreForecastRequest $request, Project $project, ForecastService $service)
    {
        $forecast = $service->create($project, $request->validated());
        return response()->json($forecast, 201);
    }
}
