<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('contract_number', 100)->unique();
            $table->enum('contract_type', ['inspection', 'engineering', 'consulting', 'testing', 'commissioning'])->default('inspection');
            $table->date('contract_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('contract_amount', 18, 2)->default(0);
            $table->decimal('amendment_amount', 18, 2)->default(0);
            $table->decimal('adjustment_amount', 18, 2)->default(0);
            $table->decimal('final_contract_amount', 18, 2)->default(0);
            $table->unsignedInteger('contract_man_days')->default(0);
            $table->foreignId('project_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'active', 'suspended', 'completed', 'cancelled', 'pending_start'])->default('draft');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
