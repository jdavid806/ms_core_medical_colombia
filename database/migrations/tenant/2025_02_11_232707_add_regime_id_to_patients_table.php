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
             // Agregar el campo regime_id (clave foránea)
             $table->unsignedBigInteger('regime_id')->nullable()->after('id'); // Puedes cambiar 'after' según tu preferencia

             // Definir la clave foránea
             $table->foreign('regime_id')
                   ->references('id')
                   ->on('regimes')
                   ->onDelete('set null'); // Si se elimina un régimen, se establece regime_id como NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['regime_id']);

            // Eliminar el campo regime_id
            $table->dropColumn('regime_id');
        });
    }
};
