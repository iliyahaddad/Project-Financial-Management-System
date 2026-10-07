<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;

class DashboardController extends Controller
{
    public function stats(ProjectService $projectService)
    {
        return response()->json([
            'stats' => $projectService->getDashboardData()
        ]);
    }
}
