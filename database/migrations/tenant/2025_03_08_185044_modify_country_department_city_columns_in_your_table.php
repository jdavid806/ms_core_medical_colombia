<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Eliminar claves foráneas
            $table->dropForeign(['country_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['city_id']);

            // Cambiar tipo de columna a string
            $table->string('country_id')->change();
            $table->string('department_id')->change();
            $table->string('city_id')->change();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->change();
            $table->unsignedBigInteger('department_id')->change();
            $table->unsignedBigInteger('city_id')->change();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->dropSoftDeletes();
        });
    }
};
