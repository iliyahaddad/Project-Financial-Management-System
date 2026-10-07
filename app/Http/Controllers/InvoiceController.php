<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Http\Requests\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $invoices = $project->invoices;
        return view('invoices.index', compact('project', 'invoices'));
    }

    public function create(Project $project)
    {
        $this->authorize('manage', $project);
        return view('invoices.create', compact('project'));
    }

    public function store(StoreInvoiceRequest $request, Project $project, InvoiceService $service)
    {
        $this->authorize('manage', $project);
        $invoice = $service->create($project, $request->validated());
        return redirect()->route('projects.invoices.show', [$project, $invoice])->with('message', 'فاکتور با موفقیت ایجاد شد');
    }

    public function approve(Project $project, Invoice $invoice)
    {
        $this->authorize('manage', $project);
        $invoice->update(['status' => 'approved']);
        return back()->with('message', 'فاکتور تایید شد');
    }

    public function show(Project $project, Invoice $invoice)
    {
        $this->authorize('view', $project);
        return view('invoices.show', compact('project', 'invoice'));
    }
}
