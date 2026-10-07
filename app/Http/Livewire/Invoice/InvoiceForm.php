<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Project;
use Livewire\Component;

class InvoiceForm extends Component
{
    public $invoice;
    public $invoice_number;
    public $period;
    public $issue_date;
    public $due_date;
    public $invoice_amount;

    public $project;

    public function mount(?Project $project = null, ?Invoice $invoice = null): void
    {
        $this->project = $project;
        if ($invoice) {
            $this->invoice = $invoice;
            $this->invoice_number = $invoice->invoice_number;
            $this->period = $invoice->period;
            $this->issue_date = $invoice->issue_date;
            $this->due_date = $invoice->due_date;
            $this->invoice_amount = $invoice->invoice_amount;
        }
    }

    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,' . ($this->invoice?->id ?? 'NULL'),
            'period' => 'nullable|string|max:255',
            'issue_date' => 'nullable|string|max:255',
            'due_date' => 'nullable|string|max:255',
            'invoice_amount' => 'required|numeric',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $validated = $this->validate();

        app(\App\Services\InvoiceService::class)->create($this->project, $validated);

        session()->flash('message', 'صورت‌وضعیت با موفقیت ثبت شد.');

        $this->reset(['invoice_number', 'period', 'issue_date', 'due_date', 'invoice_amount']);
    }

    public function render()
    {
        return view('livewire.invoice.invoice-form');
    }
}
