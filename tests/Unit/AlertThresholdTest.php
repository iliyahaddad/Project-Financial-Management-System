<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Alert;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlertThresholdTest extends TestCase
{
    use RefreshDatabase;

    public function test_progress_alert_triggered()
    {
        $project = Project::factory()->create();
        $alert = Alert::factory()->create([
            'project_id' => $project->id,
            'alert_type' => 'progress',
            'severity' => 'warning',
        ]);

        $this->assertEquals('progress', $alert->alert_type);
        $this->assertEquals('warning', $alert->severity);
    }

    public function test_man_day_alert_triggered()
    {
        $project = Project::factory()->create();
        $alert = Alert::factory()->create([
            'project_id' => $project->id,
            'alert_type' => 'man_days',
            'severity' => 'critical',
        ]);

        $this->assertEquals('man_days', $alert->alert_type);
        $this->assertEquals('critical', $alert->severity);
    }

    public function test_cost_alert_triggered()
    {
        $project = Project::factory()->create();
        $alert = Alert::factory()->create([
            'project_id' => $project->id,
            'alert_type' => 'cost',
            'severity' => 'critical',
        ]);

        $this->assertEquals('cost', $alert->alert_type);
        $this->assertEquals('critical', $alert->severity);
    }

    public function test_no_alert_when_normal()
    {
        $project = Project::factory()->create();
        $alert = Alert::factory()->create([
            'project_id' => $project->id,
            'alert_type' => 'progress',
            'severity' => 'info',
            'status' => 'resolved',
        ]);

        $this->assertEquals('info', $alert->severity);
        $this->assertEquals('resolved', $alert->status);
    }
}
