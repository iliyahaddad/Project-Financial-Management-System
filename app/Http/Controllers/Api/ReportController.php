<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function profitability(Request $request, ReportService $service)
    {
        $data = $service->getProfitabilityReport($request->all());
        return response()->json($data);
    }
}
