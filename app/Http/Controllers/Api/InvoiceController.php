<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Http\Requests\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    public function index(Project $project)
    {
        $invoices = $project->invoices;
        return response()->json($invoices);
    }

    public function show(Project $project, Invoice $invoice)
    {
        return response()->json($invoice);
    }

    public function store(StoreInvoiceRequest $request, Project $project, InvoiceService $service)
    {
        $invoice = $service->create($project, $request->validated());
        return response()->json($invoice, 201);
    }
}
