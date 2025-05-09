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
        Schema::create('vaccine_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('group_vaccine_id')->constrained('group_vaccines');
            $table->foreignId('applied_by_user_id')->nullable()->constrained('users');
            $table->integer('dose_number');
            $table->boolean('is_booster')->default(false);
            $table->text('description')->nullable();
            $table->date('application_date');
            $table->date('next_application_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_applications');
    }
};
