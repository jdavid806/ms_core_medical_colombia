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
        Schema::create('sucursals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp');
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address');
            $table->foreignId('responsible_id')->constrained('people');
            $table->timestamps();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursals');
    }
};
