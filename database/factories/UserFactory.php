<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => fake()->optional()->phoneNumber(),
            'status' => 'active',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function withRole(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => \App\Models\Role::firstOrCreate(['name' => $name], ['display_name' => $name])->id,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'ادمین سیستم',
            'email' => 'admin@mali.ir',
        ]);
    }

    public function manager(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => fake()->name() . ' (مدیر)',
        ]);
    }

    public function inspector(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => fake()->name() . ' (بازرس)',
        ]);
    }

    public function viewer(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => fake()->name() . ' (بیننده)',
        ]);
    }
}
