<?php

namespace App\Http\Livewire\Report;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;

class ReportFilter extends Component
{
    public function render()
    {
        return view('livewire.report.report-filter', [
            'clients' => Client::orderBy('name')->get(),
        ]);
    }
}
