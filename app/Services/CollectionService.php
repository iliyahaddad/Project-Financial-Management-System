<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Collection;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class CollectionService
{
    public function create(Project $project, array $data): Collection
    {
        return $this->recordCollection($project, $data);
    }

    public function recordCollection(Project $project, array $data): Collection
    {
        return DB::transaction(function () use ($project, $data) {
            $invoiceId = $data['invoice_id'] ?? null;

            if ($invoiceId) {
                $invoice = Invoice::where('id', $invoiceId)
                    ->where('project_id', $project->id)
                    ->firstOrFail();
            }

            return Collection::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function getCollectionSummary(Project $project): array
    {
        $collections = Collection::where('project_id', $project->id)->get();

        $totalCollected = (float) $collections->sum('amount');
        $totalByInvoice = $collections->groupBy('invoice_id')->map(fn($items) => $items->sum('amount'))->all();
        $totalCash = (float) $collections->where('payment_method', 'cash')->sum('amount');
        $totalTransfer = (float) $collections->where('payment_method', 'bank_transfer')->sum('amount');
        $totalCheck = (float) $collections->where('payment_method', 'check')->sum('amount');

        $invoices = Invoice::where('project_id', $project->id)->get();
        $totalApproved = (float) $invoices->where('status', 'approved')->sum('approved_amount');
        $outstanding = $totalApproved - $totalCollected;

        return [
            'total_collected' => $totalCollected,
            'total_approved_invoices' => $totalApproved,
            'outstanding' => $outstanding,
            'collection_count' => $collections->count(),
            'by_method' => [
                'cash' => $totalCash,
                'transfer' => $totalTransfer,
                'check' => $totalCheck,
            ],
            'collections' => $collections,
        ];
    }
}
