<?php

namespace App\Http\Livewire\Forecast;

use Livewire\Component;
use App\Models\Project;

class ForecastForm extends Component
{
    public ?Project $project = null;
    public $forecast_date = '';
    public $model_type = 'progress_based';
    public $actual_cost_to_date = 0;
    public $actual_progress = 0;
    public $budget_cost = 0;
    public $manual_eac = '';
    public $reason_for_override = '';
    public $notes = '';

    public function mount(?Project $project = null)
    {
        $this->project = $project;
        $this->forecast_date = now()->format('Y-m-d');
    }

    public function rules()
    {
        return [
            'forecast_date' => 'required|date',
            'model_type' => 'required|in:progress_based,budget_based,manual',
            'actual_cost_to_date' => 'nullable|numeric|min:0',
            'actual_progress' => 'nullable|numeric|between:0,100',
            'budget_cost' => 'nullable|numeric|min:0',
            'manual_eac' => 'nullable|numeric|min:0',
            'reason_for_override' => 'nullable|string',
            'notes' => 'nullable|string',
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
            'forecast_date' => $this->forecast_date,
            'model_type' => $this->model_type,
            'actual_cost_to_date' => $this->actual_cost_to_date,
            'actual_progress' => $this->actual_progress,
            'budget_cost' => $this->budget_cost,
            'manual_eac' => $this->model_type === 'manual' ? $this->manual_eac : null,
            'reason_for_override' => $this->reason_for_override,
            'notes' => $this->notes,
        ];

        app(\App\Services\ForecastService::class)->create($this->project, $data);

        $this->redirect(route('projects.forecasts.index', $this->project), navigate: true);
    }

    public function render()
    {
        return view('livewire.forecast.forecast-form');
    }
}
