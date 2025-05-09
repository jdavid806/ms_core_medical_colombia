<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\ClinicalRecord;
use App\Models\ChronicCondition;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\ClinicalRecordService;

class ClinicalRecordSummaryController extends Controller
{

    public function __construct(private ClinicalRecordService $clinicalRecordService) {}
    public function sendClinicalRecordSummary()
    {
        // Obtener registros finalizados hace más de 20 minutos
        /* $records = ClinicalRecord::where('is_active', false)
            ->where('updated_at', '<=', Carbon::now()->subMinutes(20))
            ->with(['patient', 'patient.socialSecurity', 'patient.companions'])
            ->get(); */



        $records = ClinicalRecord::with('patient')->get();

        $payload = $records->map(function ($record) {
            $patient = $record->patient;
            $age = $patient->date_of_birth ? Carbon::parse($patient->date_of_birth)->age : null;

            // Obtener antecedentes
            $antecedent = $patient->clinicalRecords()
                ->whereHas('clinicalRecordType', function ($query) {
                    $query->where('name', 'Antecedentes');
                })
                ->first();

            $antecedentData = [];
            if ($antecedent && is_array($antecedent->data)) {
                $antecedentData = collect($antecedent->data)
                    ->filter(fn($value) => !is_null($value))
                    ->map(fn($value) => trim(strip_tags($value)))
                    ->toArray();
            }

            // Obtener las 5 últimas ClinicalRecords que NO son de tipo 'Antecedentes'
            $recentConsults = $patient->clinicalRecords()
                ->whereHas('clinicalRecordType', function ($query) {
                    $query->where('name', '!=', 'Antecedentes');
                })
                ->latest('updated_at') // o 'created_at' si lo prefieres
                ->take(5)
                ->get()
                ->map(function ($rec) {
                    if ($rec->data) {
                        $antecedentData2 = collect($rec->data)
                            ->filter(fn($value) => !is_null($value))
                            ->map(fn($value) => trim(strip_tags($value)))
                            ->toArray();
                    }
                    return [
                        'id' => $rec->id,
                        'type' => $rec->clinicalRecordType->name ?? null,
                        'description' => $rec->description,
                        'data' => $antecedentData2,
                        'updated_at' => $rec->updated_at->toDateTimeString(),
                    ];
                });

            return [
                'clinical_record_id' => $record->id,
                'paciente' => [
                    'id' => $patient->id,
                    'nombre' => $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name . ' ' . $patient->second_last_name,
                    'genéro' => $patient->gender,
                    'edad' => $age,
                ],
                'antecedentes' => $antecedentData,
                'consultas_recientes' => $recentConsults,

            ];
        });


        Log::info('payload', ['payload' => $payload]);
        dd($payload);

        // Enviar los datos al endpoint
        $response = Http::post('https://hooks.medicalsoft.ai/webhook/resumen-historia-clinica', [
            'records' => $payload,
        ]);

        // Retornar respuesta
        return response()->json([
            'status' => $response->status(),
            'message' => $response->body(),
        ]);
    }

    public function patients()
    {

        
    }


    
}    
