<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\ProjectProgress as Progress;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProgressImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $project = Project::where('project_code', $row['project_code'])->firstOrFail();

        return Progress::updateOrCreate(
            [
                'project_id' => $project->id,
                'period' => $row['period'],
            ],
            [
                'planned_progress' => $row['planned_progress'],
                'actual_progress' => $row['actual_progress'],
                'management_note' => $row['management_note'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|exists:projects,project_code',
            'period' => 'required',
            'planned_progress' => 'nullable|numeric|min:0|max:100',
            'actual_progress' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
