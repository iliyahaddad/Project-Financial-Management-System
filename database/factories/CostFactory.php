<?php

namespace Database\Factories;

use App\Models\Cost;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostFactory extends Factory
{
    protected $model = Cost::class;

    public function definition(): array
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();

        return [
            'project_id' => $project->id,
            'cost_category_id' => 1,
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'description' => fake()->sentence(),
            'budget_amount' => fake()->randomFloat(2, 100000, 10000000),
            'actual_amount' => fake()->randomFloat(2, 100000, 10000000),
            'cost_center' => fake()->optional()->word(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
