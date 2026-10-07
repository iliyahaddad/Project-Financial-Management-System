<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;

class InvoicePolicy
{
    public function manage(User $user, Project $project): bool
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
}
