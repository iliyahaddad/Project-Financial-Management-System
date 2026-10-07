<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_man_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->date('period');
            $table->decimal('planned_man_days', 10, 2)->default(0);
            $table->decimal('actual_man_days', 10, 2)->default(0);
            $table->decimal('man_day_variance', 10, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->decimal('efficiency_ratio', 5, 2)->default(0);
            $table->enum('status', ['normal', 'warning', 'critical'])->default('normal');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_man_days');
    }
};
