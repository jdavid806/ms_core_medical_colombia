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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('commercial_name');
            $table->string('email')->unique();
            $table->string('whatsapp')->unique();
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address');
            $table->string('logo')->nullable();
            $table->enum('type', ['natural', 'legal']);
            $table->timestamps();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
