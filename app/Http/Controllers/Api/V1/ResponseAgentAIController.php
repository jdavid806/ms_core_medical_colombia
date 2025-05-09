<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Patient;
use App\Models\AiResponse;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Api\V1\AiResponseService;

class ResponseAgentAIController extends Controller
{
    protected $urlBase = '';
    public function __construct(private AiResponseService $aiResponseService)
    {
        $this->urlBase = env('INVENTORY_SERVICE_URL', 'http://localhost:8001/api/v1/');
    }
    public function resumenHistoriaClinica($id)
    {
        $patient = Patient::with([
            'clinicalRecords',
            'disabilities',
            'nursingNotes',
            'vaccineApplications',
            'appointments',
            'exams',
            'evolutionNotes',
            'admissions',
            'examRecipes',
        ])->findOrFail($id);


        $recentClinicalRecords = $patient->clinicalRecords()
            ->whereHas('clinicalRecordType', function ($q) {
                $q->where('name', '!=', 'Antecedentes');
            })
            ->latest()
            ->take(5)
            ->get();

        $antecedentesRecord = $patient->clinicalRecords()
            ->whereHas('clinicalRecordType', fn($q) => $q->where('name', 'Antecedentes'))
            ->latest()
            ->first();

        $antecedentes = collect(optional($antecedentesRecord)->data ?? [])
            ->filter(fn($value) => !is_null($value))
            ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);


        // Notas de enfermería del paciente
        $notasEnfermeria = $patient->nursingNotes->map(function ($note) {
            return [
                'user' => optional($note->user)->full_name, // Nombre del usuario relacionado
                'note' => strip_tags($note->note), // Limpiar etiquetas HTML
                'is_active' => $note->is_active,
            ];
        });

        // Aplicaciones de vacunas del paciente
        $aplicacionesVacunas = $patient->vaccineApplications->map(function ($application) {
            return [
                'group_vaccine' => optional($application->groupVaccine)->name, // Nombre del grupo de la vacuna
                'applied_by_user' => optional($application->appliedByUser)->full_name, // Nombre del usuario que aplicó la vacuna
                'dose_number' => $application->dose_number,
                'is_booster' => $application->is_booster,
                'description' => strip_tags($application->description), // Limpiar etiquetas HTML
                'application_date' => $application->application_date,
                'next_application_date' => $application->next_application_date,
                'is_active' => $application->is_active,
            ];
        });

        // incapacidades del paciente
        $incapacidades = $patient->disabilities->map(function ($disability) {
            return [
                'user' => optional($disability->user)->full_name, // Nombre del usuario relacionado
                'start_date' => $disability->start_date,
                'end_date' => $disability->end_date,
                'reason' => strip_tags($disability->reason), // Limpiar etiquetas HTML
                'is_active' => $disability->is_active,
            ];
        });

        // Citas del paciente
        $citas = $patient->appointments->map(function ($appointment) {
            return [
                'assigned_user_availability' => optional($appointment->userAvailability->user)->full_name, // ID de disponibilidad asignada
                'created_by_user' => optional($appointment->createdByUser)->full_name, // Nombre del usuario que creó la cita
                'appointment_state' => optional($appointment->appointmentState)->name, // Estado de la cita
                'appointment_time' => $appointment->appointment_time,
                'appointment_date' => $appointment->appointment_date,
                'attention_type' => $appointment->attention_type,
                'consultation_purpose' => $appointment->consultation_purpose, // Propósito traducido
                'consultation_type' => $appointment->consultation_type, // Tipo traducido
                'external_cause' => $appointment->external_cause, // Causa externa traducida
                'is_active' => $appointment->is_active,
                'product_id' => $appointment->product_id,
                'supervisor_user_id' => $appointment->supervisorUser?->full_name,
            ];
        });

        $examenes = $patient->exams->map(function ($exam) {
            return [
                'name' => $exam->name,
                'result' => $exam->result,
                'date' => $exam->date,
                'is_active' => $exam->is_active,
            ];
        });

        $notasEvolucion = $patient->evolutionNotes->map(function ($note) {
            return [
                'user' => optional($note->user)->full_name, // Nombre del usuario relacionado
                'note' => strip_tags($note->note), // Limpiar etiquetas HTML
                'is_active' => $note->is_active,
            ];
        });

        $admissions = $patient->admissions->map(function ($admission) {
            return [
                'admission_type' => $admission->admissionType->name,
                'admission_date' => $admission->admission_date,
                'discharge_date' => $admission->discharge_date,
                'is_active' => $admission->is_active,
            ];
        });

        $examenRecetas = $patient->examRecipes->map(function ($exam) {
            return [
                'name' => $exam->name,
                'result' => $exam->result,
                'date' => $exam->date,
                'is_active' => $exam->is_active,
            ];
        });

        $consultasRecientes = [];

        foreach ($recentClinicalRecords as $index => $record) {
            $data = collect($record->data ?? []);

            $rips = collect($data->get('rips', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);

            $values = collect($data->get('values', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);

            $receta = collect($data->get('receta', []))
                ->filter(fn($item) => is_array($item) && !empty(array_filter($item, fn($value) => !is_null($value))));

            $historiaClinica = [
                'clinical_record_id' => $record->id,
                'clinical_record_type' => $record->clinicalRecordType->name ?? null,
                'fecha' => $record->created_at->toDateString(),
                'rips' => $rips,
                'values' => $values,
            ];

            if ($receta->isNotEmpty()) {
                $historiaClinica['receta'] = $receta->toArray();
            }

            $consulta = [
                'historia_clinica' => $historiaClinica,
                'incapacidades' => $incapacidades,
                'notas_enfermeria' => $notasEnfermeria,
                'aplicaciones_vacunas' => $aplicacionesVacunas,
                'citas' => $citas,
                'examenes' => $examenes,
                'notas_evolucion' => $notasEvolucion,
                'admissions' => $admissions,
                'examen_recetas' => $examenRecetas,
            ];

            $consultasRecientes[] = $consulta;
        }



        // Resumenes recientes del agente
        $resumenes = AiResponse::where('responsable_id', $patient->id)
            ->where('responsable_type', Patient::class)
            ->where('agent_id', 2)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($resumen) {
                return [
                    'agente' => $resumen->agent->name, // Obtener nombre del agente
                    'respuesta' => [
                        'mensaje' => $resumen->response['mensaje'],
                    ],
                    'status' => $resumen->status,
                    'created_at' => Carbon::parse($resumen->created_at)->format('d-m-Y H:i:s'), // Formatear fecha
                ];
            });

        $responseData = [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'edad' => Carbon::parse($patient->date_of_birth)->age,
            'sexo' => $patient->gender,
            'antecedentes' => $antecedentes,
            'consultas_recientes' => $consultasRecientes,
            'resumenes_recientes' => $resumenes,
        ];

        $webhookUrl = config('services.webhooks.n8n-resumen-historia-clinica');

        $response = Http::post($webhookUrl, $responseData);

        // Revisa si la petición fue exitosa
        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
            return response()->json($responseData);

        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

    }

    public function postConsulta($id)
    {
        // Obtener la cita por su ID
        $appointment = Appointment::find($id);

        // Obtener el paciente relacionado con la cita
        $patient = $appointment->patient;

        $tenant = tenancy()->tenant;

        $company = Company::all()->first();

        // Filtrar las recetas asociadas con esta cita y cargar los detalles (recipeItems)
        $recipes = $patient->recipes()->where('appointment_id', $appointment->id)->with('recipeItems')->get();

        // Formatear las recetas y sus detalles para incluir en la respuesta
        $formattedRecipes = $recipes->map(function ($recipe) {
            return [
                'prescriber' => optional($recipe->prescriber)->full_name, // Médico que prescribió
                'items' => $recipe->recipeItems->map(function ($item) {
                    return [
                        'medication' => $item->medication,
                        'concentration' => $item->concentration,
                        'frequency' => $item->frequency,
                        'duration' => $item->duration,
                        'medication_type' => $item->medication_type,
                        'take_every_hours' => $item->take_every_hours,
                        'quantity' => $item->quantity,
                        'observations' => $item->observations,
                    ];
                }),
            ];
        });

        // Obtener el registro clínico más reciente relacionado con la cita
        $clinicalRecord = $appointment->clinicalRecords()
            ->orderBy('created_at', 'desc') // Orden descendente por fecha de creación
            ->first();

        // Verificar si existe el registro clínico y extraer sus relaciones
        $historiaClinica = [];
        if ($clinicalRecord) {
            $data = collect($clinicalRecord->data ?? []);

            $rips = collect($data->get('rips', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);

            $values = collect($data->get('values', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);

            $receta = collect($data->get('receta', []))
                ->filter(fn($item) => is_array($item) && !empty(array_filter($item, fn($value) => !is_null($value))));

            $historiaClinica = [
                'clinical_record_id' => $clinicalRecord->id,
                'clinical_record_type' => $clinicalRecord->clinicalRecordType->name ?? null,
                'fecha' => $clinicalRecord->created_at->toDateString(),
                'rips' => $rips,
                'values' => $values,
            ];

            if ($receta->isNotEmpty()) {
                $historiaClinica['receta'] = $receta->toArray();
            }

            // Agregar las relaciones del paciente como en resumenHistoriaClinica
            $historiaClinica['notas_enfermeria'] = $patient->nursingNotes->map(function ($note) {
                return [
                    'user' => optional($note->user)->full_name,
                    'note' => strip_tags($note->note),
                    'is_active' => $note->is_active,
                ];
            });

            $historiaClinica['aplicaciones_vacunas'] = $patient->vaccineApplications->map(function ($application) {
                return [
                    'group_vaccine' => optional($application->groupVaccine)->name,
                    'applied_by_user' => optional($application->appliedByUser)->full_name,
                    'dose_number' => $application->dose_number,
                    'is_booster' => $application->is_booster,
                    'description' => strip_tags($application->description),
                    'application_date' => $application->application_date,
                    'next_application_date' => $application->next_application_date,
                    'is_active' => $application->is_active,
                ];
            });

            $historiaClinica['incapacidades'] = $patient->disabilities->map(function ($disability) {
                return [
                    'user' => optional($disability->user)->full_name,
                    'start_date' => $disability->start_date,
                    'end_date' => $disability->end_date,
                    'reason' => strip_tags($disability->reason),
                    'is_active' => $disability->is_active,
                ];
            });

            $historiaClinica['citas'] = $patient->appointments->map(function ($appointment) {
                return [
                    'assigned_user_availability' => optional($appointment->userAvailability->user)->full_name,
                    'created_by_user' => optional($appointment->createdByUser)->full_name,
                    'appointment_state' => optional($appointment->appointmentState)->name,
                    'appointment_time' => $appointment->appointment_time,
                    'appointment_date' => $appointment->appointment_date,
                    'attention_type' => $appointment->attention_type,
                    'consultation_purpose' => $appointment->consultation_purpose,
                    'consultation_type' => $appointment->consultation_type,
                    'external_cause' => $appointment->external_cause,
                    'is_active' => $appointment->is_active,
                    'product_id' => $appointment->product_id,
                    'supervisor_user_id' => $appointment->supervisorUser?->full_name,
                ];
            });

            $historiaClinica['examenes'] = $patient->exams->map(function ($exam) {
                return [
                    'name' => $exam->name,
                    'result' => $exam->result,
                    'date' => $exam->date,
                    'is_active' => $exam->is_active,
                ];
            });

            $historiaClinica['notas_evolucion'] = $patient->evolutionNotes->map(function ($note) {
                return [
                    'user' => optional($note->user)->full_name,
                    'note' => strip_tags($note->note),
                    'is_active' => $note->is_active,
                ];
            });

            $historiaClinica['admissions'] = $patient->admissions->map(function ($admission) {
                return [
                    'admission_type' => $admission->admissionType->name,
                    'admission_date' => $admission->admission_date,
                    'discharge_date' => $admission->discharge_date,
                    'is_active' => $admission->is_active,
                ];
            });

            $historiaClinica['examen_recetas'] = $patient->examRecipes->map(function ($exam) {
                return [
                    'name' => $exam->name,
                    'result' => $exam->result,
                    'date' => $exam->date,
                    'is_active' => $exam->is_active,
                ];
            });
        }

        // Resumenes recientes del agente
        $resumenes = AiResponse::where('responsable_id', $patient->id)
            ->where('responsable_type', Patient::class)
            ->where('agent_id', 2)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($resumen) {
                return [
                    'agente' => $resumen->agent->name,
                    'respuesta' => [
                        'mensaje' => $resumen->response['mensaje'],
                    ],
                    'status' => $resumen->status,
                    'created_at' => Carbon::parse($resumen->created_at)->format('d-m-Y H:i:s'),
                ];
            });

        // Verificar si existe el registro clínico y extraer el diagnóstico principal del campo "data"
        $diagnostic = optional($clinicalRecord)->data['rips']['diagnosticoPrincipal'] ?? 'Diagnóstico no disponible';

        // Responder con los detalles del paciente, recetas, diagnóstico, resumen clínico y resumenes recientes
        $responseData = [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'edad' => Carbon::parse($patient->date_of_birth)->age . ' años',
            'sexo' => $patient->gender,
            "diagnostico" => $diagnostic,
            "receta" => $formattedRecipes,
            'medico' => $appointment->assignedUserAvailability->user->full_name,
            'especialidad' => $appointment->assignedUserAvailability->user->specialty->name,
            "tenant" => $tenant->tenancy_db_name,
            "nombre_centro" => $company->legal_name,
            "cod_pais" => "57",
            "whatsapp" => $patient->whatsapp,
            "resumen_clinico" => $historiaClinica ?? 'Resumen clínico no disponible',
            "resumenes_recientes" => $resumenes,
        ];

        $webhookUrl = config('services.webhooks.n8n-post-consultas');

        $response = Http::post($webhookUrl, $responseData);

        // Revisa si la petición fue exitosa
        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return response()->json($responseData);
    }


    public function confirmacionCita($id)
    {
        $appointment = Appointment::find($id);

        $patient = $appointment->patient;
        $tenant = tenancy()->tenant;

        $exams = $appointment->examOrders()->where('exam_order_state_id', 1)->get();

        $examenes = $exams->map(function ($exam) {
            return [
                'name' => $exam->examType->name,
                'result' => $exam->examResult->map(function ($result) {
                    return [
                        'result' => $result->results,
                        'resource_url' => $result->resource_url,
                    ];
                }),
                'date' => $exam->created_at->toDateString(),
                'is_active' => $exam->is_active,
            ];
        });

        $company = Company::all()->first();

        $responseData = [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'fecha' => $appointment->appointment_date,
            'hora' => $appointment->appointment_time,
            'medico' => $appointment->assignedUserAvailability->user->full_name,
            'especialidad' => $appointment->assignedUserAvailability->user->specialty->name,
            "enlace_pago" =>  "https://pagos.medicalsoft.com/pagar/654",
            'edad' => Carbon::parse($patient->date_of_birth)->age . ' anos',
            'sexo' => $patient->gender,
            'canal' => 'whatsapp',
            "tenant" => $tenant->tenancy_db_name,
            "nombre_centro" => $company->legal_name,
            "cod_pais" => "57",
            "whatsapp" => $patient->whatsapp,
            "examenes" => $examenes,
        ];


        // Enviar datos al webhook
        $webhookUrl = config('services.webhooks.n8n-confirmacion-cita-pago');
        $response = Http::post($webhookUrl, $responseData);

        // Revisa si la petición fue exitosa
        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return response()->json($responseData);
    }

    public function agentComercial(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $appointmentQuery = Appointment::with([
            'assignedUserAvailability.user.specialty',
            'patient'
        ])->whereNotNull('appointment_date');

        if ($startDate) {
            $appointmentQuery->whereDate('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $appointmentQuery->whereDate('appointment_date', '<=', $endDate);
        }

        $appointments = $appointmentQuery->get();

        // Agrupar por especialidad activa
        $data = $appointments
            ->filter(fn($appt) => optional($appt->assignedUserAvailability?->user?->specialty)->is_active)
            ->groupBy(function ($appt) {
                return optional($appt->assignedUserAvailability->user->specialty)->name;
            });

        $specialtyDemand = $data->map(fn($appointments, $specialty) => [
            'especialidad' => $specialty,
            'total' => $appointments->count(),
        ])->values();

        $mostDemanded = $specialtyDemand->sortByDesc('total')->take(3)->values();
        $leastDemanded = $specialtyDemand->sortBy('total')->take(3)->values();

        // Top perfiles de edad y género
        $ageGroups = [
            'Niños 0-8 años' => [0, 8],
            'Niños 9-16 años' => [9, 16],
            'Jóvenes 17-30 años' => [17, 30],
            'Adultos 31-45 años' => [31, 45],
            'Adultos mayores 46-60 años' => [46, 60],
            'Mayores de 61 años' => [61, 120],
        ];

        $now = now();

        $patients = $appointments->pluck('patient')->filter();

        $grouped = collect($patients)->map(function ($patient) use ($now, $ageGroups) {
            $age = Carbon::parse($patient->birthdate)->age ?? null;
            $groupLabel = 'Sin edad';

            foreach ($ageGroups as $label => [$min, $max]) {
                if ($age >= $min && $age <= $max) {
                    $groupLabel = $label;
                    break;
                }
            }

            return [
                'group' => "{$patient->gender} {$groupLabel}",
            ];
        })->groupBy('group')->map(fn($items, $group) => [
            'grupo' => $group,
            'frecuencia' => count($items)
        ])->sortByDesc('frecuencia')->take(3)->values();

        // Fechas con mayor demanda
        $topDatesQuery = Appointment::select('appointment_date', DB::raw('count(*) as total'))
            ->whereNotNull('appointment_date');

        if ($startDate) {
            $topDatesQuery->whereDate('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $topDatesQuery->whereDate('appointment_date', '<=', $endDate);
        }

        $topDates = $topDatesQuery
            ->groupBy('appointment_date')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('appointment_date');

        // Horas con mayor y menor demanda
        $timeQuery = Appointment::select('appointment_time', DB::raw('count(*) as total'))
            ->whereNotNull('appointment_time');

        if ($startDate) {
            $timeQuery->whereDate('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $timeQuery->whereDate('appointment_date', '<=', $endDate);
        }

        $timeDemand = $timeQuery
            ->groupBy('appointment_time')
            ->orderByDesc('total')
            ->get();

        $topHours = $timeDemand->take(3)->map(fn($item) => [
            'hora' => $item->appointment_time,
            'total' => $item->total
        ]);

        $leastHours = $timeDemand->sortBy('total')->take(3)->values()->map(fn($item) => [
            'hora' => $item->appointment_time,
            'total' => $item->total
        ]);

        $responseData = [
            'servicios_mas_demandados' => $mostDemanded,
            'servicios_menos_demandados' => $leastDemanded,
            'top_perfiles' => $grouped,
            'fechas_con_mayor_demanda' => $topDates,
            'horas_mayor_demanda' => $topHours,
            'horas_menor_demanda' => $leastHours,
        ];

        // Enviar datos al webhook
        $webhookUrl = config('services.webhooks.n8n-inteligencia-comercial');
        $response = Http::post($webhookUrl, $responseData);



        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
            return response()->json($responseData);
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }



    public function agentReportFinancial(Request $request)
    {
        // Parámetros de fecha
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date', now()); // Si no se pasa un end_date, se usa la fecha actual

        // Consulta inicial de citas
        $appointments = Appointment::with('assignedUserAvailability')
            ->whereNotNull('appointment_date')
            ->whereNotNull('product_id')
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('appointment_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('appointment_date', '<=', $endDate);
            })
            ->get();

        $grouped = $appointments->groupBy('product_id');

        $results = [];

        foreach ($grouped as $productId => $items) {
            $cantidad = $items->count();
            $tiempoPromedio = round($items->avg(fn($appt) => optional($appt->assignedUserAvailability)->appointment_duration ?? 0));

            // Consulta al microservicio admin
            $productResponse = Http::get($this->urlBase . "/products/{$productId}");

            if ($productResponse->failed()) {
                Log::warning("❗ No se pudo obtener el producto {$productId}");
                continue;
            }

            $product = $productResponse->json();

            $costo = $product['purchase_price'] ?? 0;
            $precio = $product['sale_price'] ?? 0;
            $nombre = $product['name'] ?? "Producto {$productId}";
            $fecha = $items->first()->appointment_date;

            $costoPromedio = round($costo);
            $precioFacturado = $precio * $cantidad;
            $margen = $precioFacturado - ($costoPromedio * $cantidad);

            $results[] = [
                'servicio' => $nombre,
                'costo_promedio' => $costoPromedio,
                'precio_facturado' => $precioFacturado,
                'margen' => $margen,
                'tiempo_promedio_min' => $tiempoPromedio,
                'cantidad_realizadas' => $cantidad,
                'fecha' => $fecha,
            ];
        }

        // Enviar datos al webhook
        $webhookUrl = config('services.webhooks.n8n-costo-rentabilidad');
        $response = Http::post($webhookUrl, $results);



        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
            return response()->json($results);
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }
}
