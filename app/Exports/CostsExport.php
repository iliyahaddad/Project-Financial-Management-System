<?php

namespace App\Exports;

use App\Models\ProjectCost as Cost;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class CostsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Cost::with(['project', 'costCategory'])->get()->map(function ($cost) {
            $variance = $cost->actual_amount - $cost->budget_amount;
            $variancePercent = $cost->budget_amount > 0 ? round(($variance / $cost->budget_amount) * 100, 2) : 0;
            return [
                'project' => $cost->project->project_name,
                'date' => $cost->date,
                'type' => $cost->costCategory->name ?? 'N/A',
                'description' => $cost->description,
                'budget' => $cost->budget_amount,
                'actual' => $cost->actual_amount,
                'variance' => $variance,
                'variance_percent' => $variancePercent,
                'cost_center' => $cost->cost_center,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Date',
            'Type',
            'Description',
            'Budget',
            'Actual',
            'Variance',
            'Variance%',
            'Cost Center',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
