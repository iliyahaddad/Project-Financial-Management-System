<?php

namespace App\Exports;

use App\Models\ProjectManDay as ManDay;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ManDaysExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return ManDay::with('project')->get()->map(function ($manDay) {
            $variance = $manDay->actual_man_days - $manDay->planned_man_days;
            $consumption = $manDay->planned_man_days > 0 ? ($manDay->actual_man_days / $manDay->planned_man_days) * 100 : 0;
            $efficiency = $manDay->actual_man_days > 0 ? ($manDay->planned_man_days / $manDay->actual_man_days) * 100 : 0;
            return [
                'project' => $manDay->project->project_name,
                'period' => $manDay->period,
                'planned' => $manDay->planned_man_days,
                'actual' => $manDay->actual_man_days,
                'variance' => $variance,
                'consumption' => round($consumption, 2),
                'efficiency' => round($efficiency, 2),
                'status' => $consumption > 115 ? 'Critical' : ($consumption > 100 ? 'Warning' : 'On Track'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Period',
            'Planned',
            'Actual',
            'Variance',
            'Consumption%',
            'Efficiency',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
