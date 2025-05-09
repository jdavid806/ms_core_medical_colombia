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
        Schema::create('ai_responses', function (Blueprint $table) {
            $table->id();
            // Relación polimórfica al modelo relacionado (Patient, Appointment, etc.)
            $table->morphs('responsable'); // genera responsable_id y responsable_type

            // Relación al agente que respondió
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');

            // Campo para guardar el JSON completo de respuesta
            $table->json('response');

            // Campo opcional para un mensaje o status interpretado
            $table->string('status')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_responses');
    }
};
