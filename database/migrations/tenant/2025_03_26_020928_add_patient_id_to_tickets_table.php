<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable()->after('id'); // Agrega el campo después del 'id'
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade'); // Clave foránea
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['patient_id']); // Elimina la relación de la clave foránea
            $table->dropColumn('patient_id');   // Elimina el campo
        });
    }
};
