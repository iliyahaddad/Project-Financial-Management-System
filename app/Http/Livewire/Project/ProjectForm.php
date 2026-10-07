<?php

namespace App\Http\Livewire\Project;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class ProjectForm extends Component
{
    public $project;
    public $project_code;
    public $project_name;
    public $client_id;
    public $project_manager_id;
    public $start_date;
    public $end_date;
    public $description;
    public $status;
    public $priority;
    public $progress_method;
    public $currency;
    public $notes;

    public function mount(?Project $project = null): void
    {
        if ($project) {
            $this->project = $project;
            $this->project_code = $project->project_code;
            $this->project_name = $project->project_name;
            $this->client_id = $project->client_id;
            $this->project_manager_id = $project->project_manager_id;
            $this->start_date = $project->start_date?->format('Y-m-d');
            $this->end_date = $project->end_date?->format('Y-m-d');
            $this->description = $project->description;
            $this->status = $project->status;
            $this->priority = $project->priority;
            $this->progress_method = $project->progress_method;
            $this->currency = $project->currency;
            $this->notes = $project->notes;
        }
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|string|max:255|unique:projects,project_code,' . ($this->project?->id ?? 'NULL'),
            'project_name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'project_manager_id' => 'required|exists:users,id',
            'start_date' => 'nullable|string|max:255',
            'end_date' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'progress_method' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->project) {
            $this->project->update($validated);
            session()->flash('message', 'پروژه با موفقیت به‌روز شد.');
        } else {
            Project::create($validated);
            session()->flash('message', 'پروژه با موفقیت ایجاد شد.');
        }

        $this->redirect(route('projects.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.project.project-form');
    }
}
