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
        Schema::create('history_preadmissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weight')->nullable();
            $table->foreignId('size')->nullable();
            $table->foreignId('glycemia')->nullable();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_preadmissions');
    }
};
