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
        Schema::table('cities', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna country_id
            $table->dropForeign(['country_id']); // Elimina la restricción de clave foránea
            $table->dropColumn('country_id'); // Elimina la columna

            // Agregar la clave foránea y la columna department_id
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            // Revertir: Eliminar department_id y agregar country_id
            $table->dropForeign(['department_id']); // Elimina la restricción de clave foránea
            $table->dropColumn('department_id'); // Elimina la columna

            // Agregar country_id nuevamente
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
        });
    }
};
