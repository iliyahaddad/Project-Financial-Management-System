<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts')->cascadeOnDelete();
            $table->string('amendment_number', 100)->nullable();
            $table->date('amendment_date')->nullable();
            $table->enum('amendment_type', ['extend', 'price_change', 'scope_change', 'other'])->default('other');
            $table->decimal('amount', 18, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_amendments');
    }
};
