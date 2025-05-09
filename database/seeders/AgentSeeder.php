<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = [
            'Endpoint para traer el resumen completo del paciente', 
            'Agente de Resumen de Historia Clínica para el Médico',
            'Agente de Confirmación de Cita y Pago Anticipado',
            'Agente de Análisis de Costos y Rentabilidad por Servicio',
            'Agentes IA Post - Consulta',
            'Agente de Sugerencia de Plan de Manejo Clínico',
            'Agente de Pre-Admisión Conversacional Multicanal',
            'Agente Educador del Paciente con IA',
            'Agente de Diagnóstico Diferencial Asistido por IA',
            'Agente Redactor de Historia Clínica Asistida',
            'Agente de Inteligencia Comercial Médica',
            'Agente de Evaluación de la Consulta Médica con IA',
        ];

        foreach ($agents as $agent) {
            Agent::updateOrCreate([
                'name' => $agent,
            ]);
        }
    }
}
