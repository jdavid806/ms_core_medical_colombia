<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companion_patient', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna relationship_id
            $table->dropForeign(['relationship_id']);
            $table->dropColumn('relationship_id');

            // Agregar la nueva columna relationship como string
            $table->string('relationship')->after('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companion_patient', function (Blueprint $table) {
            // Revertir los cambios en caso de rollback
            $table->dropColumn('relationship');
            $table->unsignedBigInteger('relationship_id')->after('patient_id');
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
        });
    }
};
