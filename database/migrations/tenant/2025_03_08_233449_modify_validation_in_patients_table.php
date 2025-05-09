<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Cambiar el campo 'email' a nullable
            $table->string('email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Revertir los cambios si es necesario
            $table->string('email')->nullable(false)->change();
        });
    }
};
