<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('patient_companions', function (Blueprint $table) {
            // Eliminar campos innecesarios
            $table->dropColumn(['first_name', 'last_name', 'relationship', 'phone', 'email', 'is_active']);

            // Eliminar la columna id (si existe)
            $table->dropColumn('id');

            // Agregar nuevos campos
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('companion_id');
            $table->unsignedBigInteger('relationship_id');
            $table->unsignedBigInteger('appointment_id')->nullable();

            // Definir claves foráneas
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('companion_id')->references('id')->on('companions')->onDelete('cascade');
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');

            // Definir clave primaria compuesta
            $table->primary(['patient_id', 'companion_id', 'appointment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('patient_companions', function (Blueprint $table) {
            // Eliminar clave primaria compuesta
            $table->dropPrimary(['patient_id', 'companion_id', 'appointment_id']);

            // Eliminar claves foráneas usando el nombre de la columna
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['companion_id']);
            $table->dropForeign(['relationship_id']);
            $table->dropForeign(['appointment_id']);

            // Eliminar nuevos campos
            $table->dropColumn(['patient_id', 'companion_id', 'relationship_id', 'appointment_id']);

            // Restaurar campos eliminados
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('relationship', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('is_active')->default(true);
        });
    }
};
