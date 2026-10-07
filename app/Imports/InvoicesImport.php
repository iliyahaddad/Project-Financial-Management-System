<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class InvoicesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $project = Project::where('project_code', $row['project_code'])->firstOrFail();

        return Invoice::updateOrCreate(
            [
                'project_id' => $project->id,
                'invoice_number' => $row['invoice_number'],
            ],
            [
                'period' => $row['period'] ?? null,
                'issue_date' => $row['issue_date'] ?? now(),
                'invoice_amount' => $row['invoice_amount'] ?? 0,
                'approved_amount' => $row['approved_amount'] ?? 0,
                'collected_amount' => $row['collected_amount'] ?? 0,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|exists:projects,project_code',
            'invoice_number' => 'required',
        ];
    }
}
