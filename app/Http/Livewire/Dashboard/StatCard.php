<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class StatCard extends Component
{
    public $title;
    public $value;
    public $change;
    public $icon;
    public $color;

    public function render()
    {
        return view('livewire.dashboard.stat-card');
    }
}
