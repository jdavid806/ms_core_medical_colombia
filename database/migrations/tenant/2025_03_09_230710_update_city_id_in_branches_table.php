<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['city_id']);
            // Cambiar el campo city_id a tipo string
            $table->string('city_id')->change();
        });
    }

    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            // Revertir el campo city_id a entero y agregar la clave foránea
            $table->unsignedInteger('city_id')->change();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }
};
