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
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->string('product_service_id'); // UUID o identificador único del microservicio "admin"
            $table->string('dosis');
            $table->string('via');
            $table->string('frequency')->nullable();
            $table->string('form')->nullable(); // "forma" renamed to form
            $table->string('type')->nullable(); // "tipo"
            $table->string('duration')->nullable(); // "duracion"
            $table->text('instructions')->nullable(); // "indicaciones"
            $table->unsignedInteger('quantity'); // "Cantidad"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_details');
    }
};
