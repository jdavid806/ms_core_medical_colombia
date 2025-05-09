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
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade'); 
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('whatsapp');
            $table->string('email')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['whatsapp', 'email']);
        });
    }
};
