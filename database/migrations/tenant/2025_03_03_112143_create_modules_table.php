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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: "Vaccination Module"
            $table->foreignId('branch_id')->constrained('branches'); // Assuming "branches" table exists
            $table->jsonb('allowed_reasons'); // Reasons this module handles (e.g., ["Consultation", "Vaccination"])
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_assigned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
