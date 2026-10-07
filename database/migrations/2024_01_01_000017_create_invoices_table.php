<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->string('invoice_number', 100);
            $table->date('period')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('invoice_amount', 18, 2)->default(0);
            $table->decimal('approved_amount', 18, 2)->default(0);
            $table->date('approval_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('collected_amount', 18, 2)->default(0);
            $table->date('collection_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->enum('status', ['draft', 'issued', 'approved', 'partially_paid', 'paid', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'invoice_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
