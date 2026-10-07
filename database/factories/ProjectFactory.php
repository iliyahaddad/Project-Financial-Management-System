<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $client = Client::inRandomOrder()->first() ?? Client::factory()->create();
        $startDate = fake()->dateTimeBetween('-2 years', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+2 years');

        return [
            'project_code' => 'PRJ-' . fake()->unique()->numerify('####'),
            'project_name' => fake()->sentence(3),
            'client_id' => $client->id,
            'project_manager_id' => \App\Models\User::inRandomOrder()->value('id') ?? \App\Models\User::factory()->create()->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => 'active',
            'description' => fake()->optional()->paragraph(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'active']);
    }

    public function warning(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'warning']);
    }

    public function critical(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'critical']);
    }
}
