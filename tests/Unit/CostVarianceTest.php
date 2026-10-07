<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cost;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CostVarianceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cost_variance()
    {
        $project = Project::factory()->create();
        $cost = Cost::factory()->create([
            'project_id' => $project->id,
            'budget_amount' => 10000000,
            'actual_amount' => 12000000,
        ]);

        $variance = $cost->actual_amount - $cost->budget_amount;
        $this->assertEquals(2000000, $variance);
    }

    public function test_cost_variance_percent()
    {
        $variance = 2000000;
        $budget = 10000000;
        $percent = ($variance / $budget) * 100;
        $this->assertEquals(20, $percent);
    }
}
