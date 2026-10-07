<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard.view',
            'projects.view',
            'projects.create',
            'projects.edit',
            'projects.delete',
            'projects.import',
            'projects.export',
            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'contracts.delete',
            'progress.view',
            'progress.create',
            'progress.edit',
            'progress.import',
            'man_days.view',
            'man_days.create',
            'man_days.edit',
            'man_days.import',
            'costs.view',
            'costs.create',
            'costs.edit',
            'costs.delete',
            'costs.import',
            'invoices.view',
            'invoices.create',
            'invoices.edit',
            'invoices.delete',
            'invoices.import',
            'reports.view',
            'reports.export',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'settings.view',
            'settings.edit',
            'roles.view',
            'roles.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = Role::all();
        foreach ($roles as $role) {
            $role->permissions()->sync(Permission::pluck('id'));
        }
    }
}
