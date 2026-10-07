<?php

namespace Database\Factories;

use App\Models\Alert;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory
{
    protected $model = Alert::class;

    public function definition(): array
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();

        return [
            'project_id' => $project->id,
            'alert_type' => fake()->randomElement(['progress', 'man_days', 'cost']),
            'severity' => fake()->randomElement(['info', 'warning', 'critical']),
            'message' => fake()->sentence(),
            'detected_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['open', 'resolved']),
        ];
    }
}
