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
        Schema::create('companions', function (Blueprint $table) {
            $table->id(); // ID único del acompañante
            $table->string('first_name'); // Nombre del acompañante
            $table->string('last_name'); // Apellido del acompañante
            $table->string('mobile'); // Número de teléfono 
            $table->string('email')->unique()->nullable(); // Correo electrónico (único y opcional)
            $table->boolean('is_active')->default(true); // Estado activo/inactivo (por defecto activo)
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companions');
    }
};
