<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            // Eliminar la clave foránea si existe
            $table->dropForeign(['exam_category_id']);

            // Eliminar la columna exam_category_id
            $table->dropColumn('exam_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            // Volver a agregar la columna exam_category_id
            $table->unsignedBigInteger('exam_category_id')->nullable();

            // Volver a agregar la clave foránea
            $table->foreign('exam_category_id')->references('id')->on('exam_categories')->onDelete('cascade');
        });
    }
};
