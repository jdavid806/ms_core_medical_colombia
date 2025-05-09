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
        Schema::create('conversational_funnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients'); // Relación con pacientes
            $table->foreignId('appointment_id')->constrained('appointments')->nullable(); // Relación con citas
            $table->string('channel', 255); // Canal de comunicación
            $table->foreignId('current_agent_id')->constrained('agents')->nullable()->onDelete('set null'); // Relación con agentes
            $table->string('status', 50); // Estado
            $table->text('last_message')->nullable(); // Último mensaje
            $table->string('last_event', 255)->nullable(); // Último evento
            $table->json('data_json')->nullable(); // Datos JSON adicionales

            $table->softDeletes(); // Eliminación lógica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversational_funnels');
    }

};
