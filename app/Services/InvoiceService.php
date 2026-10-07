<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function create(Project $project, array $data): Invoice
    {
        return $this->createInvoice($project, $data);
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update($data);
        return $invoice->fresh();
    }

    public function createInvoice(Project $project, array $data): Invoice
    {
        return DB::transaction(function () use ($project, $data) {
            return Invoice::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function approveInvoice(Invoice $invoice, ?int $userId): Invoice
    {
        return DB::transaction(function () use ($invoice, $userId) {
            $invoice->update([
                'status' => 'approved',
                'approved_by' => $userId,
                'approved_at' => now(),
            ]);

            return $invoice->fresh();
        });
    }

    public function getInvoiceSummary(Project $project): array
    {
        $invoices = Invoice::where('project_id', $project->id)->get();

        $totalInvoiced = (float) $invoices->sum('invoice_amount');
        $totalApproved = (float) $invoices->where('status', 'approved')->sum('approved_amount');
        $totalPending = (float) $invoices->where('status', 'issued')->sum('invoice_amount');
        $totalRejected = (float) $invoices->where('status', 'cancelled')->sum('invoice_amount');

        $totalCollected = (float) $invoices->sum(function ($invoice) {
            return $invoice->collections()->sum('amount');
        });

        $outstanding = $totalApproved - $totalCollected;

        return [
            'total_invoiced' => $totalInvoiced,
            'total_approved' => $totalApproved,
            'total_pending' => $totalPending,
            'total_rejected' => $totalRejected,
            'total_collected' => $totalCollected,
            'outstanding' => $outstanding,
            'invoice_count' => $invoices->count(),
            'approved_count' => $invoices->where('status', 'approved')->count(),
            'pending_count' => $invoices->where('status', 'pending')->count(),
        ];
    }
}
