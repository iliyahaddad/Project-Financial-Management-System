<?php

namespace App\Http\Livewire\Contract;

use App\Models\Contract;
use App\Models\Project;
use Livewire\Component;

class ContractForm extends Component
{
    public $contract;
    public $contract_number;
    public $contract_type;
    public $contract_date;
    public $start_date;
    public $end_date;
    public $contract_amount;
    public $amendment_amount;
    public $adjustment_amount;
    public $contract_man_days;
    public $description;
    public $status;

    public $project;

    public function mount(?Project $project = null, ?Contract $contract = null): void
    {
        $this->project = $project;
        if ($contract) {
            $this->contract = $contract;
            $this->contract_number = $contract->contract_number;
            $this->contract_type = $contract->contract_type;
            $this->contract_date = $contract->contract_date?->format('Y-m-d');
            $this->start_date = $contract->start_date?->format('Y-m-d');
            $this->end_date = $contract->end_date?->format('Y-m-d');
            $this->contract_amount = $contract->contract_amount;
            $this->amendment_amount = $contract->amendment_amount;
            $this->adjustment_amount = $contract->adjustment_amount;
            $this->contract_man_days = $contract->contract_man_days;
            $this->description = $contract->description;
            $this->status = $contract->status;
        }
    }

    public function rules(): array
    {
        return [
            'contract_number' => 'required|string|max:255|unique:contracts,contract_number,' . ($this->contract?->id ?? 'NULL'),
            'contract_type' => 'nullable|string|max:255',
            'contract_date' => 'nullable|string|max:255',
            'start_date' => 'nullable|string|max:255',
            'end_date' => 'nullable|string|max:255',
            'contract_amount' => 'required|numeric',
            'amendment_amount' => 'nullable|numeric',
            'adjustment_amount' => 'nullable|numeric',
            'contract_man_days' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'nullable|string|max:255',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->contract) {
            $this->contract->update($validated);
            session()->flash('message', 'قرارداد با موفقیت به‌روز شد.');
        } else {
            app(\App\Services\ContractService::class)->create($this->project, $validated);
            session()->flash('message', 'قرارداد با موفقیت ایجاد شد.');
        }

        $this->redirect(route('projects.contracts.index', $this->project ?? $this->contract->project_id), navigate: true);
    }

    public function render()
    {
        return view('livewire.contract.contract-form');
    }
}
