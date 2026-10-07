<?php

namespace App\Http\Livewire\Project;

use App\Models\Project;
use Livewire\Component;

class ProjectList extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $clientFilter = '';

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, fn($q) => $q->where('project_name', 'like', "%{$this->search}%")
                ->orWhere('project_code', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->clientFilter, fn($q) => $q->where('client_id', $this->clientFilter))
            ->get();

        return view('livewire.project.project-list', compact('projects'));
    }
}
