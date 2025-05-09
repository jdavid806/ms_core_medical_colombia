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
        Schema::create('clinical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_record_type_id')->constrained('clinical_record_types');
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('branch_id')->constrained('branches');
            $table->string('description')->nullable();
            $table->jsonb('data');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_records');
    }
};
