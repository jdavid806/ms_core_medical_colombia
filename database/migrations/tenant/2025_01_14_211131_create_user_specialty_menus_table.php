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
        Schema::create('user_specialty_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_specialty_id')->constrained('user_specialties');
            $table->foreignId('menu_id')->constrained('menus');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_specialty_menus');
    }
};
