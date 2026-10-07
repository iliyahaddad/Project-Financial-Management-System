<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\ContractAmendment;
use Illuminate\Support\Facades\DB;

class ContractService
{
    public function calculateFinalAmount(Contract $contract): float
    {
        $baseAmount = (float) ($contract->contract_amount ?? 0);

        $amendmentTotal = (float) ($contract->amendments()
            ->whereNotNull('approved_at')
            ->sum('amount') ?? 0);

        return round($baseAmount + $amendmentTotal, 2);
    }

    public function updateContractAmounts(Contract $contract): void
    {
        DB::transaction(function () use ($contract) {
            $finalAmount = $this->calculateFinalAmount($contract);

            $contract->update([
                'final_contract_amount' => $finalAmount,
            ]);
        });
    }

    public function create(Project $project, array $data): Contract
    {
        return DB::transaction(function () use ($project, $data) {
            $contract = Contract::create(array_merge($data, [
                'project_id' => $project->id,
            ]));

            $this->updateContractAmounts($contract);

            return $contract->fresh();
        });
    }

    public function update(Contract $contract, array $data): Contract
    {
        return DB::transaction(function () use ($contract, $data) {
            $contract->update($data);
            $this->updateContractAmounts($contract);

            return $contract->fresh();
        });
    }

    public function getContractProgress(Contract $contract): array
    {
        $project = $contract->project;

        if (!$project) {
            return [
                'time_progress' => 0.0,
                'cost_progress' => 0.0,
                'man_day_progress' => 0.0,
            ];
        }

        $metricsService = app(ProjectMetricsService::class);

        $timeProgress = $metricsService->calculateTimeProgress($project);

        $actualCost = (float) (\App\Models\ProjectCost::where('project_id', $project->id)->sum('actual_amount') ?? 0);
        $budget = (float) (\App\Models\ProjectBudget::where('project_id', $project->id)->sum('budget_amount') ?? 0);
        $costProgress = $budget > 0 ? min(100.0, ($actualCost / $budget) * 100) : 0.0;

        $manDayData = $metricsService->calculateManDayConsumption($project);
        $manDayProgress = $manDayData['consumption_percent'] ?? 0.0;

        return [
            'time_progress' => round($timeProgress, 2),
            'cost_progress' => round($costProgress, 2),
            'man_day_progress' => round($manDayProgress, 2),
            'contract_final_amount' => $this->calculateFinalAmount($contract),
        ];
    }
}
