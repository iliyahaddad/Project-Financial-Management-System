<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('cost_category_id')->nullable()->constrained('cost_categories')->nullOnDelete();
            $table->date('date');
            $table->string('description', 500);
            $table->decimal('budget_amount', 18, 2)->default(0);
            $table->decimal('actual_amount', 18, 2)->default(0);
            $table->decimal('cost_variance', 18, 2)->default(0);
            $table->decimal('cost_variance_percent', 8, 2)->default(0);
            $table->string('cost_center', 100)->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('document_number', 100)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_costs');
    }
};
