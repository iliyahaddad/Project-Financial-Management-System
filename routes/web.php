<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ManDayController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WbsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);

    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        Route::resource('contracts', ContractController::class)->only(['index', 'store', 'show', 'update']);
        Route::resource('wbs', WbsController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('progress', ProgressController::class)->only(['index', 'store', 'update']);
        Route::resource('man-days', ManDayController::class)->only(['index', 'store', 'update'])->parameters(['man-days' => 'manDay']);
        Route::resource('invoices', InvoiceController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('invoices/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoices.approve');
        Route::resource('collections', CollectionController::class)->only(['index', 'create', 'store']);
        Route::resource('forecasts', ForecastController::class)->only(['index', 'store', 'show']);
        Route::resource('documents', DocumentController::class)->only(['index', 'store', 'destroy']);
        Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    });

    Route::resource('costs', CostController::class)->except(['show']);
    Route::resource('alerts', AlertController::class)->only(['index', 'show']);
    Route::post('alerts/{alert}/acknowledge', [AlertController::class, 'acknowledge'])->name('alerts.acknowledge');
    Route::post('alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');
    Route::resource('settings', SettingController::class)->only(['index', 'update']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/role', [UserController::class, 'assignRole'])->name('users.assign-role');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/project-status', [ReportController::class, 'projectStatus'])->name('reports.project-status');
    Route::get('reports/cost', [ReportController::class, 'costReport'])->name('reports.cost');
    Route::get('reports/man-day', [ReportController::class, 'manDayReport'])->name('reports.man-day');
    Route::get('reports/invoice', [ReportController::class, 'invoiceReport'])->name('reports.invoice');
    Route::get('reports/collection', [ReportController::class, 'collectionReport'])->name('reports.collection');
    Route::get('reports/forecast', [ReportController::class, 'forecastReport'])->name('reports.forecast');
    Route::get('reports/profitability', [ReportController::class, 'profitabilityReport'])->name('reports.profitability');
});
