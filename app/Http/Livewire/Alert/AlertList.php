<?php

namespace App\Http\Livewire\Alert;

use App\Models\Alert;
use Livewire\Component;

class AlertList extends Component
{
    public $severityFilter = '';
    public $statusFilter = '';
    public $projectFilter = '';

    public function render()
    {
        $alerts = Alert::query()
            ->when($this->severityFilter, fn($q) => $q->where('severity', $this->severityFilter))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->projectFilter, fn($q) => $q->where('project_id', $this->projectFilter))
            ->orderByDesc('detected_at')
            ->paginate(20);

        return view('livewire.alert.alert-list', compact('alerts'));
    }
}
