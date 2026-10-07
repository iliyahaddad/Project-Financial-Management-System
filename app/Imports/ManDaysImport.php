<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\ProjectManDay as ManDay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ManDaysImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $project = Project::where('project_code', $row['project_code'])->firstOrFail();

        return ManDay::updateOrCreate(
            [
                'project_id' => $project->id,
                'period' => $row['period'],
            ],
            [
                'planned_man_days' => $row['planned_man_days'] ?? 0,
                'actual_man_days' => $row['actual_man_days'] ?? 0,
                'notes' => $row['notes'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|exists:projects,project_code',
            'planned_man_days' => 'nullable|numeric|min:0',
            'actual_man_days' => 'nullable|numeric|min:0',
        ];
    }
}
