<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('social_securities', function (Blueprint $table) {
            $table->unsignedBigInteger('entity_id')->nullable();

            // Agregar la clave foránea
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('social_securities', function (Blueprint $table) {
            $table->dropForeign(['entity_id']);
            $table->dropColumn('entity_id');
        });
    }
};
