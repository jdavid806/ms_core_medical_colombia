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
        Schema::create('remissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiver_user_id')->nullable()->constrained('users');
            $table->foreignId('remitter_user_id')->constrained('users');
            $table->foreignId('clinical_record_id')->constrained('clinical_records');
            $table->foreignId('receiver_user_specialty_id')->nullable()->constrained('user_specialties');
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
        Schema::dropIfExists('remissions');
    }
};
