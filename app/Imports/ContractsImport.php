<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Contract;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ContractsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $project = Project::where('project_code', $row['project_code'])->firstOrFail();

        $contract = Contract::updateOrCreate(
            [
                'project_id' => $project->id,
                'contract_number' => $row['contract_number'],
            ],
            [
                'contract_type' => $row['contract_type'] ?? 'inspection',
                'start_date' => $row['start_date'] ?? $project->start_date,
                'end_date' => $row['end_date'] ?? $project->end_date,
                'contract_amount' => $row['contract_amount'] ?? 0,
                'contract_man_days' => $row['contract_man_days'] ?? 0,
                'project_manager' => $row['project_manager'] ?? $project->project_manager_id,
            ]
        );

        return $contract;
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|exists:projects,project_code',
            'contract_number' => 'required',
        ];
    }
}
