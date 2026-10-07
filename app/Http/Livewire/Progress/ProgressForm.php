<?php

namespace App\Http\Livewire\Progress;

use App\Models\Project;
use App\Models\ProjectProgress;
use Livewire\Component;

class ProgressForm extends Component
{
    public $project;
    public $period;
    public $planned_progress;
    public $actual_progress;
    public $management_note;

    public function mount(?Project $project = null): void
    {
        $this->project = $project;
    }

    public function rules(): array
    {
        return [
            'period' => 'required|string|max:255',
            'planned_progress' => 'required|numeric|min:0|max:100',
            'actual_progress' => 'required|numeric|min:0|max:100',
            'management_note' => 'nullable|string',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $validated = $this->validate();

        app(\App\Services\ProgressService::class)->create($this->project, $validated);

        session()->flash('message', 'پیشرفت با موفقیت ثبت شد.');

        $this->redirect(route('projects.progress.index', $this->project), navigate: true);
    }

    public function render()
    {
        return view('livewire.progress.progress-form');
    }
}
