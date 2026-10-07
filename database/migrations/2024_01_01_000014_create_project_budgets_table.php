<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->enum('category', ['labor', 'mission', 'accommodation', 'transportation', 'equipment', 'subcontractor', 'other']);
            $table->decimal('budget_amount', 18, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_budgets');
    }
};
