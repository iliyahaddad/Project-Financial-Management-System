<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'مدیر ارشد'],
            ['name' => 'ceo', 'display_name' => 'مدیر عامل'],
            ['name' => 'finance_manager', 'display_name' => 'مدیر مالی'],
            ['name' => 'project_manager', 'display_name' => 'مدیر پروژه'],
            ['name' => 'controller', 'display_name' => 'کنترلر'],
            ['name' => 'accountant', 'display_name' => 'حسابدار'],
            ['name' => 'financial_expert', 'display_name' => 'کارشناس مالی'],
            ['name' => 'inspector', 'display_name' => 'بازرس'],
            ['name' => 'viewer', 'display_name' => 'بیننده'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
