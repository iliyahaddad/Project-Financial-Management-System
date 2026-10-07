<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Services\AlertService;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::with('project')->paginate(config('mali.pagination_per_page', 15));
        return view('alerts.index', compact('alerts'));
    }

    public function show(Alert $alert)
    {
        $alert->load('project');
        return view('alerts.show', compact('alert'));
    }

    public function acknowledge(Alert $alert)
    {
        $alert->update(['status' => 'acknowledged', 'acknowledged_by' => auth()->id(), 'acknowledged_at' => now()]);
        return back()->with('message', 'هشدار تایید شد');
    }

    public function resolve(Alert $alert, AlertService $service)
    {
        $service->resolveAlert($alert->id, auth()->id());
        return back()->with('message', 'هشدار حل شد');
    }
}
