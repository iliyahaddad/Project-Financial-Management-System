<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProjectMetricsService;
use App\Models\Project;
use App\Models\Progress;
use App\Models\ManDay;
use App\Models\Cost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectMetricsTest extends TestCase
{
    use RefreshDatabase;

    private ProjectMetricsService $metrics;

    protected function setUp(): void
    {
        parent::setUp();
        $this->metrics = new ProjectMetricsService();
    }

    public function test_calculate_time_progress()
    {
        $project = Project::factory()->create([
            'start_date' => '1401-01-01',
            'end_date' => '1402-12-29',
        ]);

        $progress = $this->metrics->calculateTimeProgress($project, '1401-06-01');
        $this->assertIsFloat($progress);
        $this->assertGreaterThanOrEqual(0, $progress);
        $this->assertLessThanOrEqual(100, $progress);
    }

    public function test_calculate_progress_variance()
    {
        $variance = $this->metrics->calculateProgressVariance(80, 90);
        $this->assertEquals(-10, $variance);
    }

    public function test_calculate_man_day_consumption()
    {
        $consumption = $this->metrics->calculateManDayConsumption(4500, 5000);
        $this->assertEquals(90, $consumption);
    }

    public function test_calculate_cost_consumption()
    {
        $consumption = $this->metrics->calculateCostConsumption(40000000, 50000000);
        $this->assertEquals(80, $consumption);
    }

    public function test_calculate_eac_progress_based()
    {
        $eac = $this->metrics->calculateEACProgressBased(100000000, 55, 44000000);
        $this->assertIsNumeric($eac);
        $this->assertGreaterThan(0, $eac);
    }

    public function test_calculate_eac_budget_based()
    {
        $eac = $this->metrics->calculateEACBudgetBased(60000, 44000, 55);
        $this->assertIsNumeric($eac);
    }

    public function test_calculate_forecast_profit()
    {
        $profit = $this->metrics->calculateForecastProfit(100000000, 44000000);
        $this->assertEquals(56000000, $profit);
    }

    public function test_calculate_project_status_normal()
    {
        $status = $this->metrics->calculateProjectStatus(-2, 2, 0.95);
        $this->assertEquals('active', $status);
    }

    public function test_calculate_project_status_warning()
    {
        $status = $this->metrics->calculateProjectStatus(-7, 5, 1.05);
        $this->assertEquals('warning', $status);
    }

    public function test_calculate_project_status_critical()
    {
        $status = $this->metrics->calculateProjectStatus(-15, 12, 1.20);
        $this->assertEquals('critical', $status);
    }
}
