<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProjectsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $client = Client::firstOrCreate(
            ['name' => $row['client_name']],
            ['name' => $row['client_name'], 'status' => 'active']
        );

        return Project::create([
            'project_code' => $row['project_code'],
            'project_name' => $row['project_name'],
            'client_id' => $client->id,
            'project_manager' => $row['project_manager'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'status' => $row['status'] ?? 'active',
            'description' => $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|unique:projects,project_code',
            'project_name' => 'required',
        ];
    }

    public function getRowCount(): int
    {
        return count($this->rows ?? []);
    }
}
