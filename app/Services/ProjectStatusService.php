<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Alert;
use Illuminate\Support\Facades\DB;

class ProjectStatusService
{
    public function getStatusColor(string $status): string
    {
        $colors = [
            'normal' => 'green',
            'warning' => 'yellow',
            'critical' => 'red',
            'active' => 'blue',
            'completed' => 'gray',
            'suspended' => 'orange',
        ];

        return $colors[$status] ?? 'gray';
    }

    public function getStatusLabel(string $status): string
    {
        $labels = [
            'normal' => 'عادی',
            'warning' => 'هشدار',
            'critical' => 'بحرانی',
            'active' => 'فعال',
            'completed' => 'تکمیل شده',
            'suspended' => 'متوقف',
        ];

        return $labels[$status] ?? $status;
    }

    public function evaluateProjectStatus(Project $project): array
    {
        $metricsService = app(ProjectMetricsService::class);
        $projectStatus = $metricsService->calculateProjectStatus($project);

        $reasons = [];

        $manDayData = $metricsService->calculateManDayConsumption($project);
        if ($manDayData['status'] !== 'normal') {
            $reasons[] = "مصرف نیروی انسانی: {$manDayData['status']}";
        }

        $costData = $metricsService->calculateCostConsumption($project);
        if ($costData['status'] !== 'normal') {
            $reasons[] = "هزینه: {$costData['status']}";
        }

        $profitData = $metricsService->calculateForecastProfit($project);
        if ($profitData['forecast_margin'] < 15) {
            $reasons[] = "حاشیه سود پایین";
        }

        $progressVariance = $metricsService->calculateProgressVariance($project);
        if ($progressVariance < -5) {
            $reasons[] = "تأخیر پیشرفت";
        }

        $openAlerts = app(AlertService::class)->getOpenAlerts($project)->count();
        if ($openAlerts > 0) {
            $reasons[] = "هشدارهای باز: {$openAlerts}";
        }

        return [
            'status' => $projectStatus,
            'color' => $this->getStatusColor($projectStatus),
            'label' => $this->getStatusLabel($projectStatus),
            'reasons' => $reasons,
        ];
    }

    public function getProjectsByStatus(string $status): \Illuminate\Support\Collection
    {
        $metricsService = app(ProjectMetricsService::class);

        $projects = Project::all();

        return $projects->filter(function ($project) use ($metricsService, $status) {
            $projectStatus = $metricsService->calculateProjectStatus($project);

            return $projectStatus === $status;
        });
    }
}
