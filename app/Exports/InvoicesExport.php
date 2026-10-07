<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class InvoicesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Invoice::with('project')->get()->map(function ($invoice) {
            $outstanding = $invoice->invoice_amount - $invoice->collected_amount;
            $approvalPercent = $invoice->invoice_amount > 0 ? round(($invoice->approved_amount / $invoice->invoice_amount) * 100, 2) : 0;
            $collectionPercent = $invoice->invoice_amount > 0 ? round(($invoice->collected_amount / $invoice->invoice_amount) * 100, 2) : 0;
            return [
                'project' => $invoice->project->project_name,
                'invoice_number' => $invoice->invoice_number,
                'period' => $invoice->period,
                'invoice_amount' => $invoice->invoice_amount,
                'approved_amount' => $invoice->approved_amount,
                'collected_amount' => $invoice->collected_amount,
                'outstanding' => $outstanding,
                'approval_percent' => $approvalPercent,
                'collection_percent' => $collectionPercent,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Invoice#',
            'Period',
            'Invoice Amount',
            'Approved',
            'Collected',
            'Outstanding',
            'Approval%',
            'Collection%',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
