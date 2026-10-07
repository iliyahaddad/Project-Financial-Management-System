<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Forecast;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForecastTest extends TestCase
{
    use RefreshDatabase;

    public function test_eac_progress_model()
    {
        $project = Project::factory()->create();
        $forecast = Forecast::factory()->create([
            'project_id' => $project->id,
            'eac_progress_based' => 85000000,
        ]);

        $this->assertIsNumeric($forecast->eac_progress_based);
        $this->assertGreaterThan(0, $forecast->eac_progress_based);
    }

    public function test_eac_budget_model()
    {
        $project = Project::factory()->create();
        $forecast = Forecast::factory()->create([
            'project_id' => $project->id,
            'eac_budget_based' => 75000000,
        ]);

        $this->assertIsNumeric($forecast->eac_budget_based);
        $this->assertGreaterThan(0, $forecast->eac_budget_based);
    }

    public function test_forecast_margin()
    {
        $project = Project::factory()->create();
        $forecast = Forecast::factory()->create([
            'project_id' => $project->id,
            'forecast_profit' => 15000000,
        ]);

        $this->assertIsNumeric($forecast->forecast_profit);
    }
}
