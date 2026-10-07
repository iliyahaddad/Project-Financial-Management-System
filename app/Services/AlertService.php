<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectManDay;
use App\Models\ProjectCost;
use App\Models\Invoice;
use App\Models\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlertService
{
    public function __construct(private SettingService $settings) {}

    public function checkAndGenerateAlerts(Project $project): void
    {
        $this->checkProgressAlert($project);
        $this->checkManDayAlert($project);
        $this->checkCostAlert($project);
        $this->checkProfitAlert($project);
        $this->checkCollectionAlert($project);
    }

    public function checkProgressAlert(Project $project): ?array
    {
        $progressVariance = app(ProjectMetricsService::class)->calculateProgressVariance($project);

        $threshold = $this->settings->get('progress_critical_threshold', -10);

        if ($progressVariance < $threshold) {
            $latestProgress = ProjectProgress::where('project_id', $project->id)
                ->orderByDesc('period')
                ->orderByDesc('id')
                ->first();

            $alertData = [
                'project_id' => $project->id,
                'type' => 'progress',
                'severity' => 'critical',
                'title' => 'تأخیر پیشرفت پروژه',
                'message' => "پیشرفت پروژه «{$project->project_name}» نسبت به برنامه " . abs($progressVariance) . " واحد زیر حد مجاز است.",
                'data' => [
                    'variance' => $progressVariance,
                    'threshold' => $threshold,
                    'actual_progress' => $latestProgress?->actual_progress ?? 0,
                    'planned_progress' => $latestProgress?->planned_progress ?? 0,
                    'period' => $latestProgress?->period ?? null,
                ],
                'generated_at' => now(),
            ];

            $this->createAlert($alertData);

            return $alertData;
        }

        return null;
    }

    public function checkManDayAlert(Project $project): ?array
    {
        $manDayData = app(ProjectMetricsService::class)->calculateManDayConsumption($project);

        $criticalRatio = $this->settings->get('man_day_critical_ratio', 1.15);

        if ($manDayData['efficiency_ratio'] > $criticalRatio) {
            $alertData = [
                'project_id' => $project->id,
                'type' => 'man_day',
                'severity' => 'critical',
                'title' => 'مصرف بیش از حد نیروی انسانی',
                'message' => "نسبت مصرف نیروی انسانی پروژه «{$project->project_name}» به {$manDayData['efficiency_ratio']} رسیده که از حد بحرانی {$criticalRatio} بالاتر است.",
                'data' => $manDayData,
                'generated_at' => now(),
            ];

            $this->createAlert($alertData);

            return $alertData;
        }

        return null;
    }

    public function checkCostAlert(Project $project): ?array
    {
        $costData = app(ProjectMetricsService::class)->calculateCostConsumption($project);

        $criticalThreshold = $this->settings->get('cost_critical_threshold', 10);

        if ($costData['variance_percent'] > $criticalThreshold) {
            $alertData = [
                'project_id' => $project->id,
                'type' => 'cost',
                'severity' => 'critical',
                'title' => 'overflow هزینه پروژه',
                'message' => "هزینه پروژه «{$project->project_name}» " . abs($costData['variance_percent']) . "% بیشتر از بودجه است و از حد بحرانی عبور کرده است.",
                'data' => $costData,
                'generated_at' => now(),
            ];

            $this->createAlert($alertData);

            return $alertData;
        }

        return null;
    }

    public function checkProfitAlert(Project $project): ?array
    {
        $profitData = app(ProjectMetricsService::class)->calculateForecastProfit($project);

        $criticalMargin = $this->settings->get('min_profit_margin_critical', 15);

        if ($profitData['forecast_margin'] < $criticalMargin) {
            $alertData = [
                'project_id' => $project->id,
                'type' => 'profit',
                'severity' => 'critical',
                'title' => 'خروج حاشیه سود',
                'message' => "حاشیه سود پیش‌بینی‌شده پروژه «{$project->project_name}» به {$profitData['forecast_margin']}% رسیده که از حد بحرانی {$criticalMargin}% پایین‌تر است.",
                'data' => $profitData,
                'generated_at' => now(),
            ];

            $this->createAlert($alertData);

            return $alertData;
        }

        return null;
    }

    public function checkCollectionAlert(Project $project): ?array
    {
        $invoiceMetrics = app(ProjectMetricsService::class)->calculateInvoiceMetrics($project);

        if ($invoiceMetrics['total_approved'] > $invoiceMetrics['total_collected']) {
            $alertData = [
                'project_id' => $project->id,
                'type' => 'collection',
                'severity' => 'warning',
                'title' => 'پرداخت‌های معوق',
                'message' => "مبلغ {$invoiceMetrics['outstanding']} ریال از فاکتورهای تأییدشده پروژه «{$project->project_name}» دریافت نشده است.",
                'data' => $invoiceMetrics,
                'generated_at' => now(),
            ];

            $this->createAlert($alertData);

            return $alertData;
        }

        return null;
    }

    public function resolveAlert(int $alertId, ?int $userId, ?string $note = null): bool
    {
        $alert = Alert::findOrFail($alertId);

        if ($alert->status === 'resolved') {
            return false;
        }

        DB::transaction(function () use ($alert, $userId, $note) {
            $alert->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => $userId,
                'resolution_note' => $note,
            ]);
        });

        return true;
    }

    public function getOpenAlerts(?Project $project = null, ?string $severity = null): \Illuminate\Support\Collection
    {
        $query = Alert::where('status', '!=', 'resolved')
            ->orderByDesc('generated_at');

        if ($project) {
            $query->where('project_id', $project->id);
        }

        if ($severity) {
            $query->where('severity', $severity);
        }

        return $query->get();
    }

    private function createAlert(array $data): void
    {
        DB::transaction(function () use ($data) {
            $exists = Alert::where('project_id', $data['project_id'])
                ->where('type', $data['type'])
                ->where('status', '!=', 'resolved')
                ->exists();

            if (!$exists) {
                Alert::create($data);
            }
        });
    }
}
