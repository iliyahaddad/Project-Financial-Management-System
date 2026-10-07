<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;

class DashboardController extends Controller
{
    public function index(ProjectService $projectService)
    {
        return view('dashboard.index', [
            'stats' => $projectService->getDashboardData()
        ]);
    }
}
