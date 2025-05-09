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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_user_availability_id')->constrained('user_availabilities');
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('appointment_state_id')->constrained('appointment_states');
            $table->time('appointment_time');
            $table->date('appointment_date');
            $table->enum('attention_type', [
                'CONSULTATION',
                'PROCEDURE'
            ]);
            $table->enum('consultation_purpose', [
                'PROMOTION',
                'PREVENTION',
                'TREATMENT',
                'REHABILITATION'
            ]);
            $table->enum('consultation_type', [
                "CONTROL",
                "EMERGENCY",
                "FIRST_TIME",
                "FOLLOW_UP"
            ]);
            $table->enum('external_cause', [
                'ACCIDENT',
                'OTHER',
                'NOT_APPLICABLE'
            ]);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
