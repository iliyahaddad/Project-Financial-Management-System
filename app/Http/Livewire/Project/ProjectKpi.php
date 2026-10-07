<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use App\Services\ProjectMetricsService;
use Livewire\Component;

class ProjectKpi extends Component
{
    public $project;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.project.project-kpi');
    }
}
