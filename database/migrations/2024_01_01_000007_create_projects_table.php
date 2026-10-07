<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code', 50)->unique();
            $table->string('project_name', 255);
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('project_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft', 'active', 'suspended', 'completed', 'cancelled', 'pending_start'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('progress_method', ['milestone', 'activity', 'manual'])->default('manual');
            $table->string('currency', 10)->default('IRR');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
