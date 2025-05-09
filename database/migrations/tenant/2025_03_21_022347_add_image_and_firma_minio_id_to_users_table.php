<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_minio_id')->nullable()->after('minio_id'); // Campo para el ID de la imagen
            $table->string('firma_minio_id')->nullable()->after('image_minio_id'); // Campo para el ID de la firma
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['image_minio_id', 'firma_minio_id']); // Eliminar ambos campos al revertir
        });
    }
};
