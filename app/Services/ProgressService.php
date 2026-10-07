<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\Wbs;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    public function create(Project $project, array $data): ProjectProgress
    {
        return $this->recordProgress($project, $data);
    }

    public function update(ProjectProgress $progress, array $data): ProjectProgress
    {
        return DB::transaction(function () use ($progress, $data) {
            $progress->update($data);

            if (isset($data['wbs_id']) && $data['wbs_id']) {
                $wbs = Wbs::find($data['wbs_id']);

                if ($wbs) {
                    $wbs->update([
                        'actual_progress' => $data['actual_progress'] ?? $wbs->actual_progress,
                    ]);
                }
            }

            return $progress->fresh();
        });
    }

    public function recordProgress(Project $project, array $data): ProjectProgress
    {
        return DB::transaction(function () use ($project, $data) {
            $progress = ProjectProgress::create(array_merge($data, [
                'project_id' => $project->id,
            ]));

            if (isset($data['wbs_id']) && $data['wbs_id']) {
                $wbs = Wbs::find($data['wbs_id']);

                if ($wbs) {
                    $wbs->update([
                        'actual_progress' => $data['actual_progress'] ?? $wbs->actual_progress,
                    ]);
                }
            }

            return $progress;
        });
    }

    public function getLatestProgress(Project $project): ?ProjectProgress
    {
        return ProjectProgress::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->first();
    }

    public function getProgressHistory(Project $project): \Illuminate\Support\Collection
    {
        return ProjectProgress::where('project_id', $project->id)
            ->orderByDesc('period')
            ->orderByDesc('id')
            ->get();
    }
}
