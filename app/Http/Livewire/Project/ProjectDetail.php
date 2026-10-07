<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Livewire\Component;

class ProjectDetail extends Component
{
    public $project;
    public $activeTab = 'overview';

    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'projectManager', 'contracts', 'progressRecords', 'manDays', 'costs', 'invoices', 'alerts']);
    }

    public function render()
    {
        return view('livewire.project.project-detail');
    }
}
