<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Alert;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function __construct(
        private ProjectMetricsService $metricsService,
        private AlertService $alertService
    ) {}

    public function getAll(array $filters = []): Collection
    {
        $query = Project::query();

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['client_id']) && $filters['client_id']) {
            $query->where('client_id', $filters['client_id']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                    ->orWhere('project_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (isset($filters['start_date_from']) && $filters['start_date_from']) {
            $query->where('start_date', '>=', $filters['start_date_from']);
        }

        if (isset($filters['start_date_to']) && $filters['start_date_to']) {
            $query->where('start_date', '<=', $filters['start_date_to']);
        }

        if (isset($filters['end_date_from']) && $filters['end_date_from']) {
            $query->where('end_date', '>=', $filters['end_date_from']);
        }

        if (isset($filters['end_date_to']) && $filters['end_date_to']) {
            $query->where('end_date', '<=', $filters['end_date_to']);
        }

        if (isset($filters['manager_id']) && $filters['manager_id']) {
            $query->where('project_manager_id', $filters['manager_id']);
        }

        return $query->orderByDesc('created_at')->get();
    }

    public function find(int $id): ?Project
    {
        return Project::find($id);
    }

    public function create(array $data): Project
    {
        return DB::transaction(function () use ($data) {
            return Project::create($data);
        });
    }

    public function update(Project $project, array $data): Project
    {
        return DB::transaction(function () use ($project, $data) {
            $project->update($data);

            return $project->fresh();
        });
    }

    public function delete(Project $project): void
    {
        DB::transaction(function () use ($project) {
            $project->delete();
        });
    }

    public function getProjectMetrics(Project $project): array
    {
        return [
            'time_progress' => $this->metricsService->calculateTimeProgress($project),
            'progress_variance' => $this->metricsService->calculateProgressVariance($project),
            'man_day_consumption' => $this->metricsService->calculateManDayConsumption($project),
            'cost_consumption' => $this->metricsService->calculateCostConsumption($project),
            'invoice_metrics' => $this->metricsService->calculateInvoiceMetrics($project),
            'eac' => $this->metricsService->calculateEAC($project),
            'forecast_profit' => $this->metricsService->calculateForecastProfit($project),
            'status' => $this->metricsService->calculateProjectStatus($project),
            'open_alerts_count' => $this->alertService->getOpenAlerts($project)->count(),
        ];
    }

    public function getDashboardData(): array
    {
        $projects = $this->getAll();

        $totalProjects = $projects->count();
        $activeProjects = $projects->where('status', 'active')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        $suspendedProjects = $projects->where('status', 'suspended')->count();

        $criticalProjects = $projects->filter(fn($p) => $this->metricsService->calculateProjectStatus($p) === 'critical')->count();
        $warningProjects = $projects->filter(fn($p) => $this->metricsService->calculateProjectStatus($p) === 'warning')->count();

        $totalContractValue = (float) $projects->sum(fn($p) => $p->contracts()->sum('final_contract_amount') ?? 0);
        $totalBudget = (float) $projects->sum(fn($p) => \App\Models\ProjectBudget::where('project_id', $p->id)->sum('budget_amount') ?? 0);
        $totalCost = (float) $projects->sum(fn($p) => \App\Models\ProjectCost::where('project_id', $p->id)->sum('actual_amount') ?? 0);
        $totalInvoiced = (float) $projects->sum(fn($p) => $this->metricsService->calculateInvoiceMetrics($p)['total_invoiced'] ?? 0);
        $totalCollected = (float) $projects->sum(fn($p) => $this->metricsService->calculateInvoiceMetrics($p)['total_collected'] ?? 0);

        $openAlerts = Alert::where('status', '!=', 'resolved')->count();
        $top = $projects->take(10);
        $budgets = $top->map(fn ($p) => (float) \App\Models\ProjectBudget::where('project_id', $p->id)->sum('budget_amount'))->values()->all();
        $actualCosts = $top->map(fn ($p) => (float) \App\Models\ProjectCost::where('project_id', $p->id)->sum('actual_amount'))->values()->all();

        return [
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'completed_projects' => $completedProjects,
            'suspended_projects' => $suspendedProjects,
            'critical_projects' => $criticalProjects,
            'warning_projects' => $warningProjects,
            'total_contract_value' => $totalContractValue,
            'total_budget' => $totalBudget,
            'total_cost' => $totalCost,
            'total_actual_cost' => $totalCost,
            'total_forecast_profit' => (float) $projects->sum(fn ($p) => $this->metricsService->calculateForecastProfit($p)['forecast_profit'] ?? 0),
            'total_invoiced' => $totalInvoiced,
            'total_collected' => $totalCollected,
            'open_alerts_count' => $openAlerts,
            'normal_count' => max(0, $totalProjects - $criticalProjects - $warningProjects),
            'warning_count' => $warningProjects,
            'critical_count' => $criticalProjects,
            'project_names' => $top->pluck('project_name')->values()->all(),
            'budgets' => $budgets,
            'actual_costs' => $actualCosts,
            'projects' => $projects,
        ];
    }
}
