<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\CostController;
use App\Http\Controllers\Api\ManDayController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ForecastController;
use App\Http\Controllers\Api\ReportController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);

    Route::apiResource('projects', ProjectController::class);

    Route::prefix('projects/{project}')->group(function () {
        Route::apiResource('contracts', ContractController::class)->only(['index', 'store', 'show']);
        Route::apiResource('progress', ProgressController::class)->only(['index', 'store', 'show']);
        Route::apiResource('costs', CostController::class)->only(['index', 'store', 'show']);
        Route::apiResource('man-days', ManDayController::class)->only(['index', 'store', 'show']);
        Route::apiResource('invoices', InvoiceController::class)->only(['index', 'store', 'show']);
        Route::apiResource('forecasts', ForecastController::class)->only(['index', 'store', 'show']);
    });

    Route::get('reports/profitability', [ReportController::class, 'profitability']);
});
