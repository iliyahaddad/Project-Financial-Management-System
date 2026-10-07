<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Wbs;
use Illuminate\Support\Facades\DB;

class WbsService
{
    public function create(Project $project, array $data): Wbs
    {
        return DB::transaction(function () use ($project, $data) {
            return Wbs::create(array_merge($data, [
                'project_id' => $project->id,
            ]));
        });
    }

    public function update(Wbs $wbs, array $data): Wbs
    {
        return DB::transaction(function () use ($wbs, $data) {
            $wbs->update($data);

            return $wbs->fresh();
        });
    }
}
