<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Forecast;
use Illuminate\Support\Facades\DB;

class ForecastService
{
    public function create(Project $project, array $data): Forecast
    {
        return $this->createForecast($project, $data);
    }

    public function createForecast(Project $project, array $data): Forecast
    {
        return DB::transaction(function () use ($project, $data) {
            return Forecast::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function getLatestForecast(Project $project): ?Forecast
    {
        return Forecast::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->first();
    }

    public function recalculateForecast(Project $project): Forecast
    {
        $metricsService = app(ProjectMetricsService::class);
        $profitData = $metricsService->calculateForecastProfit($project);
        $eacData = $metricsService->calculateEAC($project);

        $contractAmount = $profitData['contract_amount'];
        $eac = $eacData['selected_eac'];
        $forecastProfit = $profitData['forecast_profit'];
        $forecastMargin = $profitData['forecast_margin'];

        $latestForecast = $this->getLatestForecast($project);

        $period = now()->format('Y-m');

        return DB::transaction(function () use (
            $project,
            $contractAmount,
            $eac,
            $forecastProfit,
            $forecastMargin,
            $period,
            $latestForecast
        ) {
                if ($latestForecast && $latestForecast->forecast_date === $period) {
                    $latestForecast->update([
                        'actual_cost_to_date' => $contractAmount,
                        'selected_eac' => $eac,
                        'forecast_profit' => $forecastProfit,
                        'forecast_margin' => $forecastMargin,
                        'updated_at' => now(),
                    ]);

                    return $latestForecast->fresh();
                }

                return Forecast::create([
                    'project_id' => $project->id,
                    'forecast_date' => $period,
                    'actual_cost_to_date' => $contractAmount,
                    'selected_eac' => $eac,
                    'forecast_profit' => $forecastProfit,
                    'forecast_margin' => $forecastMargin,
                ]);
        });
    }
}
