<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Services\AlertService;
use App\Services\ProjectMetricsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CalculateMetrics extends Command
{
    protected $signature = 'mali:calculate-metrics
                            {--project= : Specific project ID}
                            {--force : Force recalculation}';

    protected $description = 'Recalculate all project metrics and generate alerts';

    public function handle(ProjectMetricsService $metrics, AlertService $alerts): int
    {
        $this->info('Starting metrics recalculation...');

        $projectId = $this->option('project');
        $force = $this->option('force');

        if ($projectId) {
            $projects = Project::where('id', $projectId)->get();

            if ($projects->isEmpty()) {
                $this->error("Project with ID {$projectId} not found.");

                return 1;
            }
        } else {
            $projects = Project::all();
        }

        $processed = 0;
        $errors = 0;

        foreach ($projects as $project) {
            try {
                $this->line("Processing project: {$project->project_name} (ID: {$project->id})");

                $timeProgress = $metrics->calculateTimeProgress($project);
                $progressVariance = $metrics->calculateProgressVariance($project);
                $manDayData = $metrics->calculateManDayConsumption($project);
                $costData = $metrics->calculateCostConsumption($project);
                $invoiceData = $metrics->calculateInvoiceMetrics($project);
                $eacData = $metrics->calculateEAC($project);
                $profitData = $metrics->calculateForecastProfit($project);
                $status = $metrics->calculateProjectStatus($project);

                $this->line("  Time Progress: {$timeProgress}%");
                $this->line("  Progress Variance: {$progressVariance}");
                $this->line("  Man Day Efficiency: {$manDayData['efficiency_ratio']}");
                $this->line("  Cost Variance: {$costData['variance_percent']}%");
                $this->line("  Forecast Margin: {$profitData['forecast_margin']}%");
                $this->line("  Status: {$status}");

                if ($force || $this->shouldGenerateAlerts($project, $status)) {
                    $alerts->checkAndGenerateAlerts($project);
                    $this->line('  Alerts checked');
                }

                $this->line('  Metrics calculated successfully');
                $processed++;
            } catch (\Exception $e) {
                $this->error("  Error processing project {$project->id}: {$e->getMessage()}");
                $errors++;
            }
        }

        $this->newLine();
        $this->info("Processed {$processed} projects successfully.");
        $this->warn("Failed to process {$errors} projects.");

        return $errors > 0 ? 1 : 0;
    }

    private function shouldGenerateAlerts(Project $project, string $status): bool
    {
        return true;
    }
}
