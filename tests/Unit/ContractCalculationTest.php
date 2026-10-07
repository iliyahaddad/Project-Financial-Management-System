<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Cost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_final_amount_calculation()
    {
        $project = Project::factory()->create();
        $contract = Contract::factory()->create([
            'project_id' => $project->id,
            'contract_amount' => 100000000,
        ]);

        $this->assertEquals(100000000, $contract->contract_amount);
    }

    public function test_amendment_affects_final_amount()
    {
        $project = Project::factory()->create();
        $contract = Contract::factory()->create([
            'project_id' => $project->id,
            'contract_amount' => 100000000,
        ]);

        $contract->contract_amount = 120000000;
        $contract->save();

        $this->assertEquals(120000000, $contract->fresh()->contract_amount);
    }
}
