<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_approval_percentage()
    {
        $project = Project::factory()->create();
        $invoice = Invoice::factory()->create([
            'project_id' => $project->id,
            'invoice_amount' => 10000000,
            'approved_amount' => 8000000,
        ]);

        $percent = ($invoice->approved_amount / $invoice->invoice_amount) * 100;
        $this->assertEquals(80, round($percent, 2));
    }

    public function test_collection_percentage()
    {
        $project = Project::factory()->create();
        $invoice = Invoice::factory()->create([
            'project_id' => $project->id,
            'invoice_amount' => 10000000,
            'collected_amount' => 7000000,
        ]);

        $percent = ($invoice->collected_amount / $invoice->invoice_amount) * 100;
        $this->assertEquals(70, round($percent, 2));
    }

    public function test_outstanding_calculation()
    {
        $project = Project::factory()->create();
        $invoice = Invoice::factory()->create([
            'project_id' => $project->id,
            'invoice_amount' => 10000000,
            'collected_amount' => 7000000,
        ]);

        $outstanding = $invoice->invoice_amount - $invoice->collected_amount;
        $this->assertEquals(3000000, $outstanding);
    }
}
