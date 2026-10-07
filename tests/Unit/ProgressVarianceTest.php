<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Progress;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProgressVarianceTest extends TestCase
{
    use RefreshDatabase;

    public function test_variance_calculation()
    {
        $project = Project::factory()->create();
        $progress = Progress::factory()->create([
            'project_id' => $project->id,
            'planned_progress' => 50,
            'actual_progress' => 40,
        ]);

        $variance = $progress->actual_progress - $progress->planned_progress;
        $this->assertEquals(-10, $variance);
    }

    public function test_status_determination()
    {
        $project = Project::factory()->create();
        $progress = Progress::factory()->create([
            'project_id' => $project->id,
            'planned_progress' => 50,
            'actual_progress' => 40,
        ]);

        $variance = $progress->actual_progress - $progress->planned_progress;
        $status = $variance < -10 ? 'critical' : ($variance < -5 ? 'warning' : 'on_track');
        $this->assertEquals('warning', $status);
    }
}
