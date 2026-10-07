<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole([
            'super_admin', 'ceo', 'finance_manager', 'project_manager', 'controller', 'accountant', 'financial_expert', 'inspector', 'viewer'
        ]);
    }

    public function view(User $user, Project $project): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('project_manager') && $project->project_manager_id === $user->id) {
            return true;
        }

        // No per-project assignment table exists: roles with portfolio-wide read access can view all projects.
        return $user->hasRole(['ceo', 'finance_manager', 'controller', 'accountant', 'financial_expert', 'inspector', 'viewer']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'ceo', 'finance_manager', 'project_manager', 'controller']);
    }

    public function update(User $user, Project $project): bool
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

    public function delete(User $user, Project $project): bool
    {
        return $user->hasRole('super_admin');
    }

    public function manage(User $user, Project $project): bool
    {
        return $this->update($user, $project);
    }
}
