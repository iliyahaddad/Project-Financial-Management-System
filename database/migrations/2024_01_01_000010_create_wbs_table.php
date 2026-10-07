<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('wbs')->nullOnDelete();
            $table->string('code', 50)->nullable();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('budget', 18, 2)->default(0);
            $table->date('planned_start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->decimal('weight', 5, 2)->default(0);
            $table->decimal('planned_progress', 5, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->foreignId('responsible_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'on_hold'])->default('not_started');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wbs');
    }
};
