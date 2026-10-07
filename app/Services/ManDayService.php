<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectManDay;
use Illuminate\Support\Facades\DB;

class ManDayService
{
    public function create(Project $project, array $data): ProjectManDay
    {
        return $this->recordManDays($project, $data);
    }

    public function update(ProjectManDay $manDay, array $data): ProjectManDay
    {
        $manDay->update($data);
        return $manDay->fresh();
    }

    public function recordManDays(Project $project, array $data): ProjectManDay
    {
        return DB::transaction(function () use ($project, $data) {
            return ProjectManDay::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function getLatestManDays(Project $project): ?ProjectManDay
    {
        return ProjectManDay::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->first();
    }

    public function getManDayHistory(Project $project): \Illuminate\Support\Collection
    {
        return ProjectManDay::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->get();
    }
}
