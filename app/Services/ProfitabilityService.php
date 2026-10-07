<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectCost;
use App\Models\CostCategory;
use App\Models\ProjectBudget;
use Illuminate\Support\Facades\DB;

class ProfitabilityService
{
    public function calculateProjectProfitability(Project $project): array
    {
        $contractAmount = (float) ($project->contracts()->sum('final_contract_amount') ?? 0);

        $costs = ProjectCost::where('project_id', $project->id)
            ->get()
            ->groupBy('cost_category_id');

        $costsByCategory = [];
        $totalCosts = 0.0;

        foreach ($costs as $categoryId => $categoryCosts) {
            $category = CostCategory::find($categoryId);
            $categoryName = $category?->name ?? 'نامشخص';
            $categoryTotal = (float) $categoryCosts->sum('actual_amount');

            $costsByCategory[$categoryName] = $categoryTotal;
            $totalCosts += $categoryTotal;
        }

        $grossProfit = $contractAmount - $totalCosts;
        $grossMargin = $contractAmount > 0 ? round(($grossProfit / $contractAmount) * 100, 2) : 0.0;

        return [
            'project_id' => $project->id,
            'project_name' => $project->project_name,
            'revenue' => $contractAmount,
            'costs_by_category' => $costsByCategory,
            'total_costs' => $totalCosts,
            'gross_profit' => round($grossProfit, 2),
            'gross_margin' => $grossMargin,
        ];
    }

    public function getCompanyProfitability(): array
    {
        $projects = Project::all();

        $totalRevenue = 0.0;
        $totalCosts = 0.0;
        $totalProfit = 0.0;
        $costsByCategory = [];

        $projectProfitability = [];

        foreach ($projects as $project) {
            $profitability = $this->calculateProjectProfitability($project);

            $totalRevenue += $profitability['revenue'];
            $totalCosts += $profitability['total_costs'];
            $totalProfit += $profitability['gross_profit'];

            foreach ($profitability['costs_by_category'] as $category => $amount) {
                if (!isset($costsByCategory[$category])) {
                    $costsByCategory[$category] = 0.0;
                }

                $costsByCategory[$category] += $amount;
            }

            $projectProfitability[] = $profitability;
        }

        $companyMargin = $totalRevenue > 0 ? round(($totalProfit / $totalRevenue) * 100, 2) : 0.0;

        return [
            'total_revenue' => $totalRevenue,
            'total_costs' => $totalCosts,
            'total_profit' => round($totalProfit, 2),
            'company_margin' => $companyMargin,
            'costs_by_category' => $costsByCategory,
            'projects' => $projectProfitability,
            'project_count' => $projects->count(),
        ];
    }
}
