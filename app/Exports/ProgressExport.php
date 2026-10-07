<?php

namespace App\Exports;

use App\Models\ProjectProgress as Progress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ProgressExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Progress::with('project')->get()->map(function ($progress) {
            $variance = $progress->actual_progress - $progress->planned_progress;
            return [
                'project' => $progress->project->project_name,
                'period' => $progress->period,
                'planned' => $progress->planned_progress,
                'actual' => $progress->actual_progress,
                'variance' => $variance,
                'status' => $variance < -5 ? 'Critical' : ($variance < 0 ? 'Warning' : 'On Track'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Period',
            'Planned Progress',
            'Actual Progress',
            'Variance',
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
