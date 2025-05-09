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
        Schema::create('clinical_evolution_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_record_id')->constrained('clinical_records');
            $table->foreignId('create_by_user_id')->constrained('users');
            $table->text('note');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_evolution_notes');
    }
};
