<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('wbs_id')->nullable()->constrained('wbs')->nullOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->nullOnDelete();
            $table->date('period');
            $table->decimal('planned_progress', 5, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->decimal('progress_variance', 5, 2)->default(0);
            $table->text('management_note')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['project_id', 'period', 'wbs_id', 'activity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_progress');
    }
};
