<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companions', function (Blueprint $table) {
            // Cambiar el campo 'email' a nullable y quitar la restricción de único
            $table->string('email')->nullable()->unique(false)->change();
        });
    }

    public function down()
    {
        Schema::table('companions', function (Blueprint $table) {
            // Revertir los cambios si es necesario
            $table->string('email')->nullable(false)->unique()->change();
        });
    }
};
