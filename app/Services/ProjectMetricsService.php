<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectManDay;
use App\Models\ProjectCost;
use App\Models\ProjectBudget;
use App\Models\Invoice;
use App\Models\Collection;
use App\Models\Forecast;
use App\Models\Contract;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectMetricsService
{
    public function __construct(private SettingService $settings) {}

    public function calculateTimeProgress(Project $project): float
    {
        $start = $project->start_date ? Carbon::parse($project->start_date) : null;
        $end = $project->end_date ? Carbon::parse($project->end_date) : null;
        $now = Carbon::now();

        if (!$start || !$end || $end->lte($start)) {
            return 0.0;
        }

        $totalDays = $start->diffInDays($end);
        $elapsedDays = $start->diffInDays($now);

        if ($totalDays <= 0) {
            return 0.0;
        }

        $progress = min(100.0, max(0.0, ($elapsedDays / $totalDays) * 100));

        return round($progress, 2);
    }

    public function calculateProgressVariance(Project $project, ?string $period = null): float
    {
        $query = ProjectProgress::where('project_id', $project->id);

        if ($period) {
            $query->where('period', $period);
        }

        $actual = $query->orderByDesc('period')->orderByDesc('id')->value('actual_progress') ?? 0;

        $plannedQuery = $query->select('planned_progress');
        $planned = $plannedQuery->orderByDesc('period')->orderByDesc('id')->value('planned_progress') ?? 0;

        return round($actual - $planned, 2);
    }

    public function calculateManDayConsumption(Project $project, ?string $period = null): array
    {
        $query = ProjectManDay::where('project_id', $project->id);

        if ($period) {
            $query->where('period', $period);
        }

        $actual = (float) ($query->sum('actual_man_days') ?? 0);
        $contract = (float) ($project->contracts()->where('status', 'active')->first()?->contract_man_days ?? 0);

        $consumptionPercent = $contract > 0 ? min(100.0, ($actual / $contract) * 100) : 0.0;
        $efficiencyRatio = $contract > 0 ? $actual / $contract : 0.0;
        $variance = $actual - $contract;

        $warningRatio = $this->settings->get('man_day_warning_ratio', 1.00);
        $criticalRatio = $this->settings->get('man_day_critical_ratio', 1.15);

        $status = 'normal';
        if ($efficiencyRatio >= $criticalRatio) {
            $status = 'critical';
        } elseif ($efficiencyRatio >= $warningRatio) {
            $status = 'warning';
        }

        return [
            'actual' => $actual,
            'contract' => $contract,
            'consumption_percent' => round($consumptionPercent, 2),
            'efficiency_ratio' => round($efficiencyRatio, 2),
            'variance' => round($variance, 2),
            'status' => $status,
        ];
    }

    public function calculateCostConsumption(Project $project, ?string $period = null): array
    {
        $query = ProjectCost::where('project_id', $project->id);

        if ($period) {
            $query->where('period', $period);
        }

        $actual = (float) ($query->sum('actual_amount') ?? 0);

        $budget = (float) (ProjectBudget::where('project_id', $project->id)->sum('budget_amount') ?? 0);

        $variance = $actual - $budget;
        $variancePercent = $budget > 0 ? round(($variance / $budget) * 100, 2) : 0.0;

        $warningThreshold = $this->settings->get('cost_warning_threshold', 5);
        $criticalThreshold = $this->settings->get('cost_critical_threshold', 10);

        $status = 'normal';
        if ($variancePercent >= $criticalThreshold) {
            $status = 'critical';
        } elseif ($variancePercent >= $warningThreshold) {
            $status = 'warning';
        }

        return [
            'budget' => $budget,
            'actual' => $actual,
            'variance' => round($variance, 2),
            'variance_percent' => $variancePercent,
            'status' => $status,
        ];
    }

    public function calculateInvoiceMetrics(Project $project): array
    {
        $invoices = Invoice::where('project_id', $project->id)->get();

        $totalInvoiced = (float) $invoices->sum('invoice_amount');
        $totalApproved = (float) $invoices->where('status', 'approved')->sum('approved_amount');
        $totalCollected = (float) $invoices->sum(function ($invoice) {
            return $invoice->collections()->sum('amount');
        });

        $outstanding = $totalApproved - $totalCollected;
        $approvalPercent = $totalInvoiced > 0 ? round(($totalApproved / $totalInvoiced) * 100, 2) : 0.0;
        $collectionPercent = $totalApproved > 0 ? round(($totalCollected / $totalApproved) * 100, 2) : 0.0;

        return [
            'total_invoiced' => $totalInvoiced,
            'total_approved' => $totalApproved,
            'total_collected' => $totalCollected,
            'outstanding' => $outstanding,
            'approval_percent' => $approvalPercent,
            'collection_percent' => $collectionPercent,
        ];
    }

    public function calculateEAC(Project $project, ?string $model = null, ?float $manualEac = null): array
    {
        $actualCost = (float) (ProjectCost::where('project_id', $project->id)->sum('actual_amount') ?? 0);
        $budget = (float) (ProjectBudget::where('project_id', $project->id)->sum('budget_amount') ?? 0);
        $progressVariance = $this->calculateProgressVariance($project);
        $actualProgress = ProjectProgress::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->value('actual_progress') ?? 0;

        $model = $model ?? 'progress_based';
        $systemEac = 0.0;
        $etc = 0.0;

        if ($model === 'progress_based') {
            if ($actualProgress > 0) {
                $systemEac = $actualCost / ($actualProgress / 100);
            } else {
                $systemEac = $budget;
            }
            $etc = max(0.0, $systemEac - $actualCost);
        } elseif ($model === 'budget_based') {
            $systemEac = $actualCost + $budget;
            $etc = max(0.0, $budget);
        } else {
            $systemEac = $budget;
            $etc = max(0.0, $budget - $actualCost);
        }

        $selectedEac = $manualEac !== null ? $manualEac : $systemEac;

        return [
            'system_eac' => round($systemEac, 2),
            'manual_eac' => $manualEac !== null ? round($manualEac, 2) : null,
            'selected_eac' => round($selectedEac, 2),
            'etc' => round($etc, 2),
            'model_type' => $model,
        ];
    }

    public function calculateForecastProfit(Project $project): array
    {
        $contractAmount = (float) ($project->contracts()->sum('final_contract_amount') ?? 0);
        $eacData = $this->calculateEAC($project);
        $eac = $eacData['selected_eac'];

        $forecastProfit = $contractAmount - $eac;
        $forecastMargin = $contractAmount > 0 ? round(($forecastProfit / $contractAmount) * 100, 2) : 0.0;

        return [
            'contract_amount' => $contractAmount,
            'eac' => $eac,
            'forecast_profit' => $forecastProfit,
            'forecast_margin' => $forecastMargin,
        ];
    }

    public function calculateProjectStatus(Project $project): string
    {
        $manDayData = $this->calculateManDayConsumption($project);
        $costData = $this->calculateCostConsumption($project);
        $profitData = $this->calculateForecastProfit($project);
        $progressVariance = $this->calculateProgressVariance($project);

        $warningThresholds = $this->settings->getThresholds();

        $progressWarning = $warningThresholds['progress_warning_threshold'] ?? -5;
        $progressCritical = $warningThresholds['progress_critical_threshold'] ?? -10;
        $costWarning = $warningThresholds['cost_warning_threshold'] ?? 5;
        $costCritical = $warningThresholds['cost_critical_threshold'] ?? 10;
        $profitWarning = $warningThresholds['min_profit_margin_warning'] ?? 25;
        $profitCritical = $warningThresholds['min_profit_margin_critical'] ?? 15;
        $manDayCritical = $warningThresholds['man_day_critical_ratio'] ?? 1.15;
        $manDayWarning = $warningThresholds['man_day_warning_ratio'] ?? 1.00;

        $isCritical = $manDayData['efficiency_ratio'] > $manDayCritical
            || $costData['variance_percent'] > $costCritical
            || $profitData['forecast_margin'] < $profitCritical
            || $progressVariance < $progressCritical;

        $isWarning = $manDayData['efficiency_ratio'] > $manDayWarning
            || $costData['variance_percent'] > $costWarning
            || $profitData['forecast_margin'] < $profitWarning
            || $progressVariance < $progressWarning;

        if ($isCritical) {
            return 'critical';
        }

        if ($isWarning) {
            return 'warning';
        }

        return 'normal';
    }

    public function getAllMetrics(Project $project): array
    {
        return [
            'time_progress' => $this->calculateTimeProgress($project),
            'progress_variance' => $this->calculateProgressVariance($project),
            'man_day_consumption' => $this->calculateManDayConsumption($project),
            'cost_consumption' => $this->calculateCostConsumption($project),
            'invoice_metrics' => $this->calculateInvoiceMetrics($project),
            'eac' => $this->calculateEAC($project),
            'forecast_profit' => $this->calculateForecastProfit($project),
            'status' => $this->calculateProjectStatus($project),
        ];
    }
}
