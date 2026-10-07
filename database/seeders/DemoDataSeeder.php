<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Wbs;
use App\Models\Activity;
use App\Models\ProjectProgress;
use App\Models\ProjectManDay;
use App\Models\ProjectCost;
use App\Models\CostCategory;
use App\Models\Invoice;
use App\Models\Forecast;
use App\Models\Alert;
use App\Models\Document;
use App\Models\AuditLog;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            Client::firstOrCreate(['name' => 'پتروشیمی south'], ['name' => 'پتروشیمی south', 'status' => 'active']),
            Client::firstOrCreate(['name' => 'شرکت صنعتی north'], ['name' => 'شرکت صنعتی north', 'status' => 'active']),
            Client::firstOrCreate(['name' => 'شرکت آب و برق east'], ['name' => 'شرکت آب و برق east', 'status' => 'active']),
            Client::firstOrCreate(['name' => 'شرکت توان west'], ['name' => 'شرکت توان west', 'status' => 'active']),
            Client::firstOrCreate(['name' => 'شرکت فنی center'], ['name' => 'شرکت فنی center', 'status' => 'active']),
        ];

        $projects = [];
        $data = [
            [
                'code' => 'PRJ-1401', 'name' => 'پروژه بازرسی پتروشیمی south', 'client' => $clients[0],
                'status' => 'active', 'progress' => 55, 'man_days' => [3400, 5000],
                'budget' => 60000000000, 'actual_cost' => 44000000000, 'contract' => 100000000000,
                'start' => '1401-01-01', 'end' => '1402-12-29',
            ],
            [
                'code' => 'PRJ-1402', 'name' => 'پروژه بازرسی صنعتی north', 'client' => $clients[1],
                'status' => 'active', 'progress' => 78, 'man_days' => [1200, 2000],
                'budget' => 30000000000, 'actual_cost' => 24000000000, 'contract' => 45000000000,
                'start' => '1401-03-01', 'end' => '1402-09-30',
            ],
            [
                'code' => 'PRJ-1403', 'name' => 'پروژه نظارت بر سد east', 'client' => $clients[2],
                'status' => 'warning', 'progress' => 35, 'man_days' => [800, 1500],
                'budget' => 20000000000, 'actual_cost' => 18000000000, 'contract' => 35000000000,
                'start' => '1401-06-01', 'end' => '1403-05-01',
            ],
            [
                'code' => 'PRJ-1404', 'name' => 'پروژه بازرسی نیروگاه west', 'client' => $clients[3],
                'status' => 'critical', 'progress' => 20, 'man_days' => [1200, 1000],
                'budget' => 15000000000, 'actual_cost' => 16000000000, 'contract' => 40000000000,
                'start' => '1402-01-01', 'end' => '1403-12-29',
            ],
            [
                'code' => 'PRJ-1405', 'name' => 'پروژه کارشناسی فنی center', 'client' => $clients[4],
                'status' => 'active', 'progress' => 90, 'man_days' => [800, 1000],
                'budget' => 12000000000, 'actual_cost' => 10000000000, 'contract' => 25000000000,
                'start' => '1401-01-01', 'end' => '1402-06-30',
            ],
        ];

        foreach ($data as $item) {
            $project = Project::create([
                'project_code' => $item['code'],
                'project_name' => $item['name'],
                'client_id' => $item['client']->id,
                'status' => $item['status'],
                'start_date' => $item['start'],
                'end_date' => $item['end'],
                'project_manager' => 'مدیر پروژه ' . $item['code'],
                'description' => 'توضیحات پروژه ' . $item['name'],
            ]);

            $projects[] = $project;

            Contract::create([
                'project_id' => $project->id,
                'contract_number' => 'CNT-' . $item['code'],
                'contract_type' => 'inspection',
                'start_date' => $item['start'],
                'end_date' => $item['end'],
                'contract_amount' => $item['contract'],
                'contract_man_days' => $item['man_days'][1],
                'project_manager' => $project->project_manager,
            ]);

            for ($i = 1; $i <= 4; $i++) {
                $wbs = Wbs::create([
                    'project_id' => $project->id,
                    'code' => $item['code'] . '-W' . $i,
                    'name' => 'زیرمجموعه ' . $i . ' - ' . $item['name'],
                    'description' => 'توضیحات زیرمجموعه ' . $i,
                    'budget' => $item['budget'] / 4,
                ]);

                for ($j = 1; $j <= 4; $j++) {
                    Activity::create([
                        'wbs_id' => $wbs->id,
                        'activity_code' => $wbs->code . '-A' . $j,
                        'name' => 'فعالیت ' . $j . ' زیرمجموعه ' . $i,
                        'description' => 'توضیحات فعالیت ' . $j,
                        'start_date' => $item['start'],
                        'end_date' => $item['end'],
                        'planned_man_days' => $item['man_days'][1] / 16,
                    ]);
                }
            }

            $start = Carbon::createFromFormat('Y-m-d', $item['start']);
            $end = Carbon::createFromFormat('Y-m-d', $item['end']);
            $months = $start->diffInMonths($end) + 1;
            $months = min($months, 12);

            for ($m = 0; $m < $months; $m++) {
                $period = $start->copy()->addMonths($m)->format('Y/m');
                $plannedProgress = min(100, ($m + 1) * (100 / $months));
                $actualProgress = $plannedProgress * ($item['progress'] / 100);

                ProjectProgress::create([
                    'project_id' => $project->id,
                    'period' => $period,
                    'planned_progress' => round($plannedProgress, 2),
                    'actual_progress' => round($actualProgress, 2),
                    'management_note' => null,
                ]);

                $plannedMd = $item['man_days'][1] / $months;
                $actualMd = $plannedMd * ($item['man_days'][0] / $item['man_days'][1]);

                ProjectManDay::create([
                    'project_id' => $project->id,
                    'period' => $period,
                    'planned_man_days' => round($plannedMd, 2),
                    'actual_man_days' => round($actualMd, 2),
                    'notes' => null,
                ]);
            }

            $category = CostCategory::firstOrCreate(['name' => 'عمومی'], ['name' => 'عمومی', 'status' => 'active']);
            for ($i = 1; $i <= 15; $i++) {
                $date = $start->copy()->addDays(rand(0, 300))->format('Y-m-d');
                $budget = $item['budget'] / 15;
                $actual = $item['actual_cost'] / 15 * (1 + (rand(-10, 10) / 100));

                ProjectCost::create([
                    'project_id' => $project->id,
                    'cost_category_id' => $category->id,
                    'date' => $date,
                    'description' => 'هزینه ' . $i . ' پروژه ' . $item['code'],
                    'budget_amount' => $budget,
                    'actual_amount' => $actual,
                    'cost_center' => 'مرکز ' . rand(1, 5),
                    'notes' => null,
                ]);
            }

            for ($i = 1; $i <= 6; $i++) {
                $period = $start->copy()->addMonths($i)->format('Y/m');
                $amount = $item['contract'] / 6;
                Invoice::create([
                    'project_id' => $project->id,
                    'invoice_number' => 'INV-' . $item['code'] . '-' . $i,
                    'period' => $period,
                    'issue_date' => $start->copy()->addMonths($i)->format('Y-m-d'),
                    'invoice_amount' => $amount,
                    'approved_amount' => $amount * (rand(80, 100) / 100),
                    'collected_amount' => $amount * (rand(60, 90) / 100),
                ]);
            }

            Forecast::create([
                'project_id' => $project->id,
                'forecast_date' => now(),
                'eac_progress_based' => $item['contract'] * ($item['progress'] / 100),
                'eac_budget_based' => $item['actual_cost'] + ($item['budget'] - $item['actual_cost']) * 0.5,
                'forecast_profit' => $item['contract'] - $item['actual_cost'],
            ]);

            $alertTypes = ['progress', 'man_days', 'cost'];
            for ($i = 1; $i <= 5; $i++) {
                $type = $alertTypes[array_rand($alertTypes)];
                Alert::create([
                    'project_id' => $project->id,
                    'alert_type' => $type,
                    'severity' => $item['status'] === 'critical' ? 'critical' : ($item['status'] === 'warning' ? 'warning' : 'info'),
                    'message' => 'هشدار ' . $type . ' برای پروژه ' . $item['name'],
                    'detected_at' => now()->subDays(rand(1, 30)),
                    'status' => $i % 2 === 0 ? 'resolved' : 'open',
                ]);
            }

            for ($i = 1; $i <= 3; $i++) {
                Document::create([
                    'project_id' => $project->id,
                    'name' => 'سند ' . $i . ' - ' . $item['name'],
                    'type' => 'pdf',
                    'path' => 'documents/' . $item['code'] . '/doc-' . $i . '.pdf',
                    'size' => rand(100, 5000),
                ]);
            }

            AuditLog::create([
                'project_id' => $project->id,
                'action' => 'demo_data_created',
                'description' => 'ایجاد داده‌های دمو برای پروژه ' . $item['name'],
                'user_id' => null,
            ]);
        }
    }
}
