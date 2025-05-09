<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_companions', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['relationship_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companion_patient', function (Blueprint $table) {
            // Recrear la clave foránea en caso de rollback
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
        });
    }
};
