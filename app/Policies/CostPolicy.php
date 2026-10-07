<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProjectCost;

class CostPolicy
{
    public function viewAny(User $user, Project $project): bool
    {
        return true;
    }

    public function view(User $user, ProjectCost $cost): bool
    {
        return true;
    }

    public function create(User $user, Project $project): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole(['ceo', 'finance_manager', 'controller'])) {
            return true;
        }

        if ($user->hasRole('project_manager') && $project->project_manager_id === $user->id) {
            return true;
        }

        return false;
    }

    public function update(User $user, Project $project): bool
    {
        return $this->create($user, $project);
    }

    public function delete(User $user, Project $project): bool
    {
        return $this->create($user, $project);
    }
}
