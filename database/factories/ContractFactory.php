<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();

        return [
            'project_id' => $project->id,
            'contract_number' => 'CNT-' . fake()->unique()->numerify('######'),
            'contract_type' => fake()->randomElement(['inspection', 'consulting', 'supervision']),
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'contract_amount' => fake()->randomFloat(2, 10000000, 500000000),
            'contract_man_days' => fake()->numberBetween(500, 5000),
            'project_manager_id' => $project->project_manager_id,
        ];
    }
}
