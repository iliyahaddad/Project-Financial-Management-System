<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $metrics = app(\App\Services\ProjectMetricsService::class);

        $projects = Project::query()
            ->with('client')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('project_name', 'like', "%{$this->search}%")
                    ->orWhere('project_code', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate($this->perPage);

        $projects->getCollection()->transform(function ($project) use ($metrics) {
            $m = $metrics->getAllMetrics($project);
            $cost = $m['cost_consumption'] ?? [];
            $project->setAttribute('actual_progress', (float) ($project->latestProgress?->actual_progress ?? 0));
            $project->setAttribute('time_progress', $m['time_progress'] ?? 0);
            $project->setAttribute('man_day_consumption', $m['man_day_consumption']['consumption_percent'] ?? 0);
            $project->setAttribute('cost_consumption', ($cost['budget'] ?? 0) > 0 ? round($cost['actual'] / $cost['budget'] * 100, 1) : 0);
            $project->setAttribute('forecast_margin', $m['forecast_profit']['forecast_margin'] ?? 0);
            return $project;
        });

        return view('livewire.dashboard.project-table', compact('projects'));
    }
}
