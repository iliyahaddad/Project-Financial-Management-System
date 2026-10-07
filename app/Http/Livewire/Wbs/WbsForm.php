<?php

namespace App\Http\Livewire\Wbs;

use Livewire\Component;
use App\Models\Project;
use App\Models\Wbs;

class WbsForm extends Component
{
    public ?Project $project = null;
    public ?Wbs $wbs = null;
    public $name = '';
    public $code = '';
    public $description = '';
    public $budget = 0;
    public $planned_start_date = '';
    public $planned_end_date = '';
    public $weight = 0;
    public $planned_progress = 0;
    public $actual_progress = 0;
    public $responsible_person_id = '';
    public $status = 'not_started';

    public function mount(?Project $project = null, ?Wbs $wbs = null)
    {
        $this->project = $project;
        if ($wbs) {
            $this->wbs = $wbs;
            $this->name = $wbs->name;
            $this->code = $wbs->code ?? '';
            $this->description = $wbs->description ?? '';
            $this->budget = $wbs->budget ?? 0;
            $this->planned_start_date = $wbs->planned_start_date?->format('Y-m-d') ?? '';
            $this->planned_end_date = $wbs->planned_end_date?->format('Y-m-d') ?? '';
            $this->weight = $wbs->weight ?? 0;
            $this->planned_progress = $wbs->planned_progress ?? 0;
            $this->actual_progress = $wbs->actual_progress ?? 0;
            $this->responsible_person_id = $wbs->responsible_person_id ?? '';
            $this->status = $wbs->status ?? 'not_started';
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'budget' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|between:0,100',
            'planned_progress' => 'nullable|numeric|between:0,100',
            'actual_progress' => 'nullable|numeric|between:0,100',
            'status' => 'required|in:not_started,in_progress,completed,on_hold',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'budget' => $this->budget,
            'planned_start_date' => $this->planned_start_date ?: null,
            'planned_end_date' => $this->planned_end_date ?: null,
            'weight' => $this->weight,
            'planned_progress' => $this->planned_progress,
            'actual_progress' => $this->actual_progress,
            'responsible_person_id' => $this->responsible_person_id ?: null,
            'status' => $this->status,
        ];

        if ($this->wbs) {
            $this->wbs->update($data);
        } else {
            app(\App\Services\WbsService::class)->create($this->project, $data);
        }

        $this->redirect(route('projects.wbs.index', $this->project), navigate: true);
    }

    public function render()
    {
        return view('livewire.wbs.wbs-form');
    }
}
