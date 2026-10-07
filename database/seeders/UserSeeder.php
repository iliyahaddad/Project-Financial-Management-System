<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Role::all() as $i => $role) {
            $email = $role->name === 'super_admin' ? 'admin@mali.ir' : $role->name . '@mali.ir';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $role->name === 'super_admin' ? 'ادمین سیستم' : $role->display_name,
                    'password' => Hash::make('password'),
                    'phone' => '0912000' . str_pad((string) (1000 + $i), 4, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'role_id' => $role->id,
                ]
            );
        }
    }
}
