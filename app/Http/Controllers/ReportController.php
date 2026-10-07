<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Services\CollectionService;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /** key => [title, view, [heading => property]] */
    private const REPORTS = [
        'project-status' => ['گزارش وضعیت پروژه‌ها', 'reports.project-status', [
            'پروژه' => 'project_name', 'پیشرفت %' => 'actual_progress', 'زمان %' => 'time_progress',
            'نفرروز %' => 'man_day_consumption', 'هزینه %' => 'cost_consumption',
            'حاشیه سود %' => 'forecast_margin', 'وصول %' => 'collection_percent', 'وضعیت' => 'status',
        ]],
        'cost' => ['گزارش هزینه‌ها', 'reports.cost', [
            'پروژه' => 'project_name', 'بودجه' => 'budget', 'هزینه واقعی' => 'actual_cost', 'انحراف' => 'variance',
        ]],
        'man-day' => ['گزارش نفرروز', 'reports.man-day', [
            'پروژه' => 'project_name', 'نفرروز قرارداد' => 'contract_man_days',
            'نفرروز مصرفی' => 'actual_man_days', 'مصرف %' => 'man_day_consumption',
        ]],
        'invoice' => ['گزارش صورت‌وضعیت‌ها', 'reports.invoice', [
            'پروژه' => 'project_name', 'صادرشده' => 'total_invoiced', 'تاییدشده' => 'total_approved', 'وصول‌شده' => 'total_collected',
        ]],
        'collection' => ['گزارش وصول مطالبات', 'reports.collection', [
            'پروژه' => 'project_name', 'تاییدشده' => 'total_approved', 'وصول‌شده' => 'total_collected', 'مانده' => 'outstanding',
        ]],
        'forecast' => ['گزارش پیش‌بینی', 'reports.forecast', [
            'پروژه' => 'project_name', 'هزینه تاکنون' => 'actual_cost', 'EAC' => 'selected_eac', 'سود پیش‌بینی' => 'forecast_profit',
        ]],
        'profitability' => ['گزارش سودآوری', 'reports.profitability', [
            'پروژه' => 'project_name', 'درآمد' => 'final_contract_amount', 'هزینه' => 'actual_cost', 'سود ناخالص' => 'gross_profit',
        ]],
    ];

    public function index()
    {
        return view('reports.index');
    }

    public function projectStatus(Request $r, ReportService $s)
    {
        return $this->respond($r, 'project-status', $s->getProjectStatusReport($r->all()), function ($row) {
            $p = $row['project'];
            $invoices = app(\App\Services\InvoiceService::class)->getInvoiceSummary($p);
            $cost = $row['cost_consumption'];
            return $this->obj($p, [
                'actual_progress' => (float) ($p->latestProgress?->actual_progress ?? 0),
                'time_progress' => $row['time_progress'],
                'man_day_consumption' => $row['man_day_consumption']['consumption_percent'] ?? 0,
                'cost_consumption' => ($cost['budget'] ?? 0) > 0 ? round($cost['actual'] / $cost['budget'] * 100, 1) : 0,
                'forecast_margin' => $row['forecast_profit']['forecast_margin'] ?? 0,
                'collection_percent' => $invoices['total_approved'] > 0 ? round($invoices['total_collected'] / $invoices['total_approved'] * 100, 1) : 0,
                'status' => $row['status'],
            ]);
        });
    }

    public function costReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'cost', $s->getCostReport($r->all()), fn ($row) => $this->obj($row['project'], [
            'budget' => $row['budget'], 'actual_cost' => $row['actual'], 'variance' => $row['variance'],
        ]));
    }

    public function manDayReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'man-day', $s->getManDayReport($r->all()), fn ($row) => $this->obj($row['project'], [
            'contract_man_days' => $row['contract_man_days'], 'actual_man_days' => $row['actual_man_days'],
            'man_day_consumption' => $row['consumption_percent'],
        ]));
    }

    public function invoiceReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'invoice', $s->getInvoiceReport($r->all()), fn ($row) => $this->obj($row['project'], [
            'total_invoiced' => $row['total_invoiced'], 'total_approved' => $row['total_approved'], 'total_collected' => $row['total_collected'],
        ]));
    }

    public function collectionReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'collection', $s->getCollectionReport($r->all()), function ($row) {
            $approved = app(CollectionService::class)->getCollectionSummary($row['project'])['total_approved_invoices'];
            return $this->obj($row['project'], [
                'total_approved' => $approved, 'total_collected' => $row['total_collected'], 'outstanding' => $approved - $row['total_collected'],
            ]);
        });
    }

    public function forecastReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'forecast', $s->getForecastReport($r->all()), fn ($row) => $this->obj($row['project'], [
            'contract_amount' => $row['contract_amount'], 'selected_eac' => $row['eac'],
            'actual_cost' => app(\App\Services\CostControlService::class)->getCostSummary($row['project'])['actual'],
            'forecast_profit' => $row['forecast_profit'],
        ]));
    }

    public function profitabilityReport(Request $r, ReportService $s)
    {
        return $this->respond($r, 'profitability', $s->getProfitabilityReport($r->all()), fn ($row) => (object) [
            'project_name' => $row['project_name'], 'final_contract_amount' => $row['revenue'],
            'actual_cost' => $row['total_costs'], 'gross_profit' => $row['gross_profit'],
            'contracts' => collect(),
        ]);
    }

    /** Merge computed fields onto the project model so views can read them as attributes. */
    private function obj($project, array $fields)
    {
        foreach ($fields as $k => $v) {
            $project->setAttribute($k, $v);
        }
        return $project;
    }

    private function respond(Request $request, string $key, $rows, callable $map)
    {
        [$title, $view, $columns] = self::REPORTS[$key];
        $projects = collect($rows)->map($map);

        $export = $request->query('export');
        if (in_array($export, ['excel', 'pdf'], true)) {
            $headings = array_keys($columns);
            $data = $projects->map(fn ($p) => array_map(fn ($prop) => $p->{$prop} ?? '', array_values($columns)))->all();

            return $export === 'excel'
                ? Excel::download(new ReportExport($headings, $data), "report-{$key}.xlsx")
                : Pdf::loadView('reports.pdf', ['title' => $title, 'headings' => $headings, 'rows' => $data])->download("report-{$key}.pdf");
        }

        return view($view, ['projects' => $projects]);
    }
}
