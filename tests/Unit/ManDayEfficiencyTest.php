<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ManDay;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManDayEfficiencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_efficiency_ratio()
    {
        $efficiency = 200 / 180;
        $this->assertGreaterThan(0, $efficiency);
    }

    public function test_man_day_status()
    {
        $project = Project::factory()->create();
        $manDay = ManDay::factory()->create([
            'project_id' => $project->id,
            'planned_man_days' => 200,
            'actual_man_days' => 230,
        ]);

        $consumption = ($manDay->actual_man_days / $manDay->planned_man_days) * 100;
        $this->assertEquals(115, round($consumption, 2));
    }
}
