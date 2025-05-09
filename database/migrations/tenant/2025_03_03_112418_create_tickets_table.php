<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Auto-generated (e.g., "T-001")
            $table->string('phone'); // Required (registered or non-registered patient)
            $table->string('email')->nullable();
            $table->enum('reason', [
                'ADMISSION_PRESCHEDULED',
                'CONSULTATION_GENERAL',
                'SPECIALIST',
                'VACCINATION',
                'LABORATORY',
                'EXIT_CONSULTATION',
                'OTHER'
            ]); // Determines the module (e.g., "Vaccination")
            $table->enum('priority', [
                'NONE',
                'SENIOR',
                'PREGNANT',
                'DISABILITY',
                'CHILDREN_BABY'
            ])->default('NONE');
            $table->enum('status', [
                'PENDING',
                'CALLED',
                'COMPLETED',
                'MISSED'
            ])->default('PENDING');
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
