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
        Schema::create('chronic_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('cie11_code')->index(); // Ej: 'E11'
            $table->string('name')->nullable();  // Ej: 'Diabetes tipo 2'
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chronic_conditions');
    }
};
