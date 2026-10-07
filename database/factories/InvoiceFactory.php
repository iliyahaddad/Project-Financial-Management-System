<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();
        $amount = fake()->randomFloat(2, 1000000, 50000000);

        return [
            'project_id' => $project->id,
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'period' => fake()->monthName(),
            'issue_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'invoice_amount' => $amount,
            'approved_amount' => $amount * fake()->randomFloat(2, 0.8, 1),
            'collected_amount' => $amount * fake()->randomFloat(2, 0.6, 0.95),
        ];
    }
}
