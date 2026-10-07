<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectManDay;
use App\Models\ProjectCost;
use App\Models\Invoice;
use App\Models\Collection;
use App\Models\Forecast;
use App\Models\ProjectBudget;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    private array $defaultFilters = [
        'start_date_from' => null,
        'start_date_to' => null,
        'end_date_from' => null,
        'end_date_to' => null,
        'client_id' => null,
        'manager_id' => null,
        'status' => null,
    ];

    public function getProjectStatusReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $metricsService = app(ProjectMetricsService::class);

            return [
                'project' => $project,
                'status' => $metricsService->calculateProjectStatus($project),
                'time_progress' => $metricsService->calculateTimeProgress($project),
                'progress_variance' => $metricsService->calculateProgressVariance($project),
                'man_day_consumption' => $metricsService->calculateManDayConsumption($project),
                'cost_consumption' => $metricsService->calculateCostConsumption($project),
                'forecast_profit' => $metricsService->calculateForecastProfit($project),
            ];
        });
    }

    public function getCostReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $costService = app(CostControlService::class);
            $summary = $costService->getCostSummary($project);
            $byCategory = $costService->getCostByCategory($project);

            return [
                'project' => $project,
                'budget' => $summary['budget'],
                'actual' => $summary['actual'],
                'variance' => $summary['variance'],
                'variance_percent' => $summary['variance_percent'],
                'by_category' => $byCategory,
            ];
        });
    }

    public function getManDayReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $metricsService = app(ProjectMetricsService::class);
            $manDayData = $metricsService->calculateManDayConsumption($project);

            return [
                'project' => $project,
                'actual_man_days' => $manDayData['actual'],
                'contract_man_days' => $manDayData['contract'],
                'consumption_percent' => $manDayData['consumption_percent'],
                'efficiency_ratio' => $manDayData['efficiency_ratio'],
                'variance' => $manDayData['variance'],
                'status' => $manDayData['status'],
            ];
        });
    }

    public function getInvoiceReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $invoiceService = app(InvoiceService::class);
            $summary = $invoiceService->getInvoiceSummary($project);

            return [
                'project' => $project,
                'total_invoiced' => $summary['total_invoiced'],
                'total_approved' => $summary['total_approved'],
                'total_pending' => $summary['total_pending'],
                'total_collected' => $summary['total_collected'],
                'outstanding' => $summary['outstanding'],
                'approval_percent' => $summary['total_invoiced'] > 0 ? round(($summary['total_approved'] / $summary['total_invoiced']) * 100, 2) : 0.0,
                'collection_percent' => $summary['total_approved'] > 0 ? round(($summary['total_collected'] / $summary['total_approved']) * 100, 2) : 0.0,
            ];
        });
    }

    public function getCollectionReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $collectionService = app(CollectionService::class);
            $summary = $collectionService->getCollectionSummary($project);

            return [
                'project' => $project,
                'total_collected' => $summary['total_collected'],
                'outstanding' => $summary['outstanding'],
                'collection_count' => $summary['collection_count'],
                'by_method' => $summary['by_method'],
            ];
        });
    }

    public function getForecastReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $metricsService = app(ProjectMetricsService::class);
            $eacData = $metricsService->calculateEAC($project);
            $profitData = $metricsService->calculateForecastProfit($project);

            return [
                'project' => $project,
                'contract_amount' => $profitData['contract_amount'],
                'eac' => $eacData['selected_eac'],
                'etc' => $eacData['etc'],
                'forecast_profit' => $profitData['forecast_profit'],
                'forecast_margin' => $profitData['forecast_margin'],
                'eac_model' => $eacData['model_type'],
            ];
        });
    }

    public function getProfitabilityReport(array $filters): BaseCollection
    {
        $filters = array_merge($this->defaultFilters, $filters);

        $projects = $this->getFilteredProjects($filters);

        return $projects->map(function ($project) {
            $profitabilityService = app(ProfitabilityService::class);

            return $profitabilityService->calculateProjectProfitability($project);
        });
    }

    public function getProjectComparison(array $projectIds): array
    {
        $projects = Project::whereIn('id', $projectIds)->get();
        $metricsService = app(ProjectMetricsService::class);

        $comparison = [];

        foreach ($projects as $project) {
            $comparison[] = [
                'project_id' => $project->id,
                'project_name' => $project->project_name,
                'time_progress' => $metricsService->calculateTimeProgress($project),
                'progress_variance' => $metricsService->calculateProgressVariance($project),
                'man_day_consumption' => $metricsService->calculateManDayConsumption($project),
                'cost_consumption' => $metricsService->calculateCostConsumption($project),
                'invoice_metrics' => $metricsService->calculateInvoiceMetrics($project),
                'forecast_profit' => $metricsService->calculateForecastProfit($project),
                'status' => $metricsService->calculateProjectStatus($project),
            ];
        }

        return [
            'projects' => $comparison,
            'count' => count($comparison),
        ];
    }

    private function getFilteredProjects(array $filters): \Illuminate\Support\Collection
    {
        $query = Project::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['manager_id'])) {
            $query->where('project_manager_id', $filters['manager_id']);
        }

        if (!empty($filters['start_date_from'])) {
            $query->where('start_date', '>=', $filters['start_date_from']);
        }

        if (!empty($filters['start_date_to'])) {
            $query->where('start_date', '<=', $filters['start_date_to']);
        }

        if (!empty($filters['end_date_from'])) {
            $query->where('end_date', '>=', $filters['end_date_from']);
        }

        if (!empty($filters['end_date_to'])) {
            $query->where('end_date', '<=', $filters['end_date_to']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                    ->orWhere('project_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('created_at')->get();
    }
}
