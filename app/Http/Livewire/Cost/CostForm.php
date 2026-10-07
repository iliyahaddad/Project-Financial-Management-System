<?php

namespace App\Http\Livewire\Cost;

use App\Models\ProjectCost;
use Livewire\Component;

class CostForm extends Component
{
    public $cost;
    public $project_id;
    public $date;
    public $cost_category_id;
    public $description;
    public $budget_amount;
    public $actual_amount;
    public $cost_center;
    public $employee_id;
    public $document_number;
    public $notes;

    public function mount(?ProjectCost $cost = null): void
    {
        if ($cost) {
            $this->cost = $cost;
            $this->project_id = $cost->project_id;
            $this->date = $cost->date?->format('Y-m-d');
            $this->cost_category_id = $cost->cost_category_id;
            $this->description = $cost->description;
            $this->budget_amount = $cost->budget_amount;
            $this->actual_amount = $cost->actual_amount;
            $this->cost_center = $cost->cost_center;
            $this->employee_id = $cost->employee_id;
            $this->document_number = $cost->document_number;
            $this->notes = $cost->notes;
        }
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'cost_category_id' => 'nullable|exists:cost_categories,id',
            'description' => 'required|string|max:255',
            'budget_amount' => 'nullable|numeric',
            'actual_amount' => 'nullable|numeric',
            'cost_center' => 'nullable|string|max:255',
            'employee_id' => 'nullable|exists:users,id',
            'document_number' => 'nullable|string|max:255',
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

        if ($this->cost) {
            $this->cost->update($validated);
            session()->flash('message', 'هزینه با موفقیت به‌روز شد.');
        } else {
            app(\App\Services\CostControlService::class)->create(\App\Models\Project::findOrFail($validated['project_id']), $validated);
            session()->flash('message', 'هزینه با موفقیت ثبت شد.');
        }

        $this->dispatch('cost-saved');
    }

    public function render()
    {
        return view('livewire.cost.cost-form');
    }
}
