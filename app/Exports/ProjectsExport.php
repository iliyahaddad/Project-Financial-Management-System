<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ProjectsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Project::with('client')->get()->map(function ($project) {
            return [
                'project_code' => $project->project_code,
                'project_name' => $project->project_name,
                'client' => $project->client->name ?? 'N/A',
                'manager' => $project->manager->name ?? '',
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'status' => $project->status,
                'progress' => $project->latestProgress?->actual_progress ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Project Code',
            'Project Name',
            'Client',
            'Manager',
            'Start Date',
            'End Date',
            'Status',
            'Progress',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
