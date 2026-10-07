<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contract;

class ContractPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Contract $contract): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->can('view', $contract->project);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'ceo', 'finance_manager', 'project_manager', 'controller']);
    }

    public function update(User $user, Contract $contract): bool
    {
        return $user->hasRole(['super_admin', 'ceo', 'finance_manager', 'project_manager', 'controller']);
    }

    public function delete(User $user, Contract $contract): bool
    {
        return $user->hasRole('super_admin');
    }
}
