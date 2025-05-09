<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companion_patient', function (Blueprint $table) {
            // Claves foráneas
            $table->unsignedBigInteger('companion_id'); // FK a companions
            $table->unsignedBigInteger('patient_id'); // FK a patients
            $table->unsignedBigInteger('relationship_id'); // FK a relationships

            // Timestamps (opcional, si deseas registrar cuándo se creó o actualizó la relación)
            $table->timestamps();

            // Claves foráneas y restricciones
            $table->foreign('companion_id')->references('id')->on('companions')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');

            // Clave primaria compuesta
            $table->primary(['companion_id', 'patient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('companion_patient');
    }
};
