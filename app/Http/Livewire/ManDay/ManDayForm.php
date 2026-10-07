<?php

namespace App\Http\Livewire\ManDay;

use App\Models\Project;
use App\Models\ProjectManDay;
use Livewire\Component;

class ManDayForm extends Component
{
    public $project;
    public $period;
    public $planned_man_days;
    public $actual_man_days;
    public $notes;

    public function mount(?Project $project = null): void
    {
        $this->project = $project;
    }

    public function rules(): array
    {
        return [
            'period' => 'required|string|max:255',
            'planned_man_days' => 'required|numeric|min:0',
            'actual_man_days' => 'required|numeric|min:0',
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

        app(\App\Services\ManDayService::class)->create($this->project, $validated);

        session()->flash('message', 'نفرروز با موفقیت ثبت شد.');

        $this->redirect(route('projects.man-days.index', $this->project), navigate: true);
    }

    public function render()
    {
        return view('livewire.man-day.man-day-form');
    }
}
