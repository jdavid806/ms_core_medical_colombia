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
        Schema::create('group_vaccines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccination_group_id')->constrained('vaccination_groups');
            $table->foreignId('vaccine_id')->constrained('vaccines');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_vaccines');
    }
};
