<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->date('forecast_date');
            $table->enum('model_type', ['progress_based', 'budget_based', 'manual'])->default('progress_based');
            $table->decimal('actual_cost_to_date', 18, 2)->default(0);
            $table->decimal('actual_progress', 5, 2)->default(0);
            $table->decimal('budget_cost', 18, 2)->default(0);
            $table->decimal('etc', 18, 2)->default(0);
            $table->decimal('eac_system', 18, 2)->default(0);
            $table->decimal('manual_eac', 18, 2)->nullable();
            $table->decimal('selected_eac', 18, 2)->nullable();
            $table->decimal('forecast_profit', 18, 2)->default(0);
            $table->decimal('forecast_margin', 8, 2)->default(0);
            $table->text('reason_for_override')->nullable();
            $table->foreignId('override_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('override_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
