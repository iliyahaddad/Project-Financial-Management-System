<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wbs_id')->constrained('wbs')->cascadeOnDelete();
            $table->string('activity_code', 50)->nullable();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('planned_weight', 5, 2)->default(0);
            $table->decimal('planned_progress', 5, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->foreignId('responsible_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'on_hold'])->default('not_started');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
