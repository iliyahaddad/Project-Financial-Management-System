<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\ProjectCost as Cost;
use App\Models\CostCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class CostsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $project = Project::where('project_code', $row['project_code'])->firstOrFail();

        $costCategory = CostCategory::firstOrCreate(
            ['name' => $row['cost_type']],
            ['name' => $row['cost_type'], 'status' => 'active']
        );

        return Cost::create([
            'project_id' => $project->id,
            'cost_category_id' => $costCategory->id,
            'date' => $row['date'],
            'description' => $row['description'] ?? null,
            'budget_amount' => $row['budget_amount'] ?? 0,
            'actual_amount' => $row['actual_amount'] ?? 0,
            'cost_center' => $row['cost_center'] ?? null,
            'notes' => $row['notes'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|exists:projects,project_code',
            'budget_amount' => 'nullable|numeric|min:0',
            'actual_amount' => 'nullable|numeric|min:0',
        ];
    }
}
