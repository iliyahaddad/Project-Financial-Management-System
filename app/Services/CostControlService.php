<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectCost;
use App\Models\CostCategory;
use App\Models\ProjectBudget;
use Illuminate\Support\Facades\DB;

class CostControlService
{
    public function create(Project $project, array $data): ProjectCost
    {
        return $this->recordCost($project, $data);
    }

    public function update(ProjectCost $cost, array $data): ProjectCost
    {
        $cost->update($data);
        return $cost->fresh();
    }

    public function recordCost(Project $project, array $data): ProjectCost
    {
        return DB::transaction(function () use ($project, $data) {
            return ProjectCost::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function getCostSummary(Project $project): array
    {
        $actual = (float) (ProjectCost::where('project_id', $project->id)->sum('actual_amount') ?? 0);
        $budget = (float) (ProjectBudget::where('project_id', $project->id)->sum('budget_amount') ?? 0);
        $variance = $actual - $budget;
        $variancePercent = $budget > 0 ? round(($variance / $budget) * 100, 2) : 0.0;

        $byCategory = ProjectCost::where('project_id', $project->id)
            ->select('cost_category_id', DB::raw('SUM(actual_amount) as total'))
            ->groupBy('cost_category_id')
            ->get()
            ->keyBy('cost_category_id');

        return [
            'budget' => $budget,
            'actual' => $actual,
            'variance' => round($variance, 2),
            'variance_percent' => $variancePercent,
            'by_category' => $byCategory,
        ];
    }

    public function getCostByCategory(Project $project): \Illuminate\Support\Collection
    {
        return ProjectCost::where('project_id', $project->id)
            ->select('cost_category_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('cost_category_id')
            ->get()
            ->map(function ($item) {
                $category = CostCategory::find($item->cost_category_id);

                return [
                    'category_id' => $item->cost_category_id,
                    'category_name' => $category?->name ?? 'نامشخص',
                    'total' => (float) $item->total,
                    'count' => (int) $item->count,
                ];
            });
    }
}
