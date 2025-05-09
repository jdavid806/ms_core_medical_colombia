<?php

namespace App\Services;

use App\Helpers\InvoiceHelper;
use App\Models\Admission;
use App\Models\Company;
use App\Models\ExamOrder;
use App\Models\ExamOrderItem;
use App\Models\ExamOrderState;
use App\Models\ExamType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\PatientRepository;
use App\Repositories\AdmissionRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdmissionService extends OneToManyService
{
    protected $repository;
    protected $inventoryService;
    protected $examOrderService;

    protected $baseUrl;

    public function __construct(
        AdmissionRepository $repository,
        private PatientRepository $patientRepository,
        private UserService $userService,
        private AppointmentService $appointmentService,
        InventoryService $inventoryService,
        ExamOrderService $examOrderService
    ) {
        $this->repository = $repository;
        $this->inventoryService = $inventoryService;
        $this->examOrderService = $examOrderService;
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo.localhost:8001/api/v1/admin');
    }

    /* public function createAdmission(array $data, int $patientId)
    {
        $admissionData = $data['admission']; // Ahora es un objeto, no un array
        $invoiceData = $data['invoice'];
        $invoiceDetailData = $data['invoice_detail'];
        $paymentsData = $data['payments'];
        try {
            $response = Http::post("http://dev.monaros.co/api/v1/admin/invoices/sales", [
                'invoice' => $invoiceData,
                'invoice_detail' => $invoiceDetailData,
                'payments' => $paymentsData,
            ]);


            // Verificar si la petición fue exitosa
            if ($response->failed()) {
                throw new HttpResponseException(response()->json([
                    'error' => 'Error en la creación de la factura',
                    'details' => $response->json() ?? 'Respuesta vacía del servidor'
                ], $response->status()));
            }

            $responseData = $response->json();

            // Validar que la respuesta contiene el ID de la factura
            if (!isset($responseData['invoice']['id'])) {
                throw new HttpResponseException(response()->json([
                    'error' => 'La respuesta del microservicio no contiene el ID de la factura',
                    'details' => $responseData
                ], 422));
            }

            $invoiceId = $responseData['invoice']['id'];

            // Añadir el ID de la factura a los datos de la admisión
            $admissionData['invoice_id'] = $invoiceId;

            // Crear la admisión
            $admission = $this->repository->createForParent($patientId, $admissionData);

            return response()->json([
                'message' => 'Admisión y factura creadas correctamente',
                'admission' => $admission,
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'details' => $e->getMessage()
            ], 500);
        }
    } */


    public function createAdmission(array $data, int $patientId)
    {

        $admissionData = $data['admission'];
        $invoiceData = $data['invoice'];
        $invoiceDetailData = $data['invoice_detail'];
        $paymentsData = $data['payments'];

        $externalId = $data['external_id'];

        $appointmentId = $admissionData['appointment_id'];

        try {

            $user = $this->userService->getUserByExternalId($externalId);

            $admissionData['user_id'] = $user->id;

            $admissionData['admission_type_id'] = 1;


            $this->appointmentService->desactiveAppointment($appointmentId);

            if (!$user) {
                throw new HttpResponseException(response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404));
            }

            // Asignar el ID del paciente al campo user_id en invoice
            $invoiceData['user_id'] = $user->id; // Asegúrate de que $user->id[0] existe

            $response = Http::post("http://foo2.localhost:8001/api/v1/admin/invoices/sales", [
                'invoice' => $invoiceData,
                'invoice_detail' => $invoiceDetailData,
                'payments' => $paymentsData,
            ]);

            Log::info($response->json());

            if ($response->failed()) {
                throw new HttpResponseException(response()->json([
                    'error' => 'Error en la creación de la factura',
                    'details' => $response->json() ?? 'Respuesta vacía del servidor'
                ], $response->status()));
            }

            $responseData = $response->json();

            Log::info($responseData);

            if (!isset($responseData['invoice']['id'])) {
                throw new HttpResponseException(response()->json([
                    'error' => 'La respuesta del microservicio no contiene el ID de la factura',
                    'details' => $responseData
                ], 422));
            }

            $invoiceId = $responseData['invoice']['id'];
            $admissionData['invoice_id'] = $invoiceId;

            $admission = $this->repository->createForParent($patientId, $admissionData);

            return response()->json([
                'message' => 'Admisión y factura creadas correctamente',
                'admission' => $admission,
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function newCreateAdmission(array $data, int $patientId)
    {
        return DB::transaction(function () use ($data, $patientId) {

            $admission = $data['admission'];

            //dd($admission);
            $invoice = $data['invoice'];
            $invoiceDetails = $data['invoice_detail'];
            $payments = $data['payments'];

            $exams = [];



            foreach ($invoiceDetails as $invoiceDetail) {
                $associatedProduct = $this->inventoryService->getProductById($invoiceDetail['product_id']);

                if (isset($associatedProduct["exam_type_id"])) {
                    $exams[] = $associatedProduct["exam_type_id"];
                }
            }

            if (count($exams) > 0) {
                $examOrder = ExamOrder::create([
                    'exam_type_id' => $exams[0],
                    'patient_id' => $patientId,
                    'exam_order_state_id' => ExamOrderState::where('name', 'generated')->first()->id,
                    'appointment_id' => $admission['appointment_id']
                ]);

                foreach ($exams as $exam) {
                    ExamOrderItem::create([
                        'exam_order_id' => $examOrder->id,
                        'exam_type_id' => $exam
                    ]);
                }
            }

            $companyConsumerBilling = null;

            $externalId = $data['external_id'];
            $medicalUser = $this->userService->getUserByExternalId($externalId);

            $invoice['user_id'] = $externalId;
            $invoiceCode = "";
            $invoiceReminder = 0;

            if (
                $invoice['type'] == 'entity' ||
                ($invoice['type'] == 'public' && !$data["public_invoice"])
            ) {
                $code = InvoiceHelper::generateInvoiceCode();
                $invoiceCode = $code;
                $invoice['resolution_number'] = "0";
            } else if ($invoice['type'] == 'public') {
                $company = Company::all()->first();
                $company->load('billings');
                $companyConsumerBilling = $company->billings->where('type', 'consumer')->first();

                $nextResolutionCodeResponse = Http::withHeaders([
                    'Accept' => 'application/json'
                ])->get(
                    $this->baseUrl . "/invoices/next/resolution-invoice-code/" . $companyConsumerBilling->resolution_number
                );

                Log::info($nextResolutionCodeResponse->json());

                if ($nextResolutionCodeResponse->failed()) {
                    throw new HttpResponseException(response()->json([
                        'error' => 'Error al traer el último codigo de factura',
                        'details' => $nextResolutionCodeResponse->json() ?? 'Respuesta vacía del servidor'
                    ], $nextResolutionCodeResponse->status()));
                }

                $nextResolutionCodeData = $nextResolutionCodeResponse->json();

                $invoice['resolution_number'] = $companyConsumerBilling->resolution_number;

                $invoiceCode = $nextResolutionCodeData['found'] ?
                    $nextResolutionCodeData['last_invoice_code'] :
                    $companyConsumerBilling->dian_prefix . "-" . $companyConsumerBilling->invoice_from;

                $invoiceReminder = $nextResolutionCodeData['found'] ?
                    (int)$companyConsumerBilling->invoice_to - (int)$nextResolutionCodeData['last_invoice_code_number'] :
                    (int)$companyConsumerBilling->invoice_to - (int)$companyConsumerBilling->invoice_from;
            }

            $invoice['invoice_code'] = $invoiceCode;

            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post(
                $this->baseUrl . "/invoices/sales",
                [
                    'invoice' => $invoice,
                    'invoice_detail' => $invoiceDetails,
                    'payments' => $payments,
                ]
            );

            Log::info($response->json());

            if ($response->failed()) {
                throw new HttpResponseException(response()->json([
                    'error' => 'Error en la creación de la factura',
                    'details' => $response->json() ?? 'Respuesta vacía del servidor'
                ], $response->status()));
            }

            $createdInvoice = $response->json();

            $invoiceId = $createdInvoice['invoice']['id'];


            $createdAdmission = Admission::create([
                "patient_id" => $patientId,
                "user_id" => $medicalUser->id,
                "admission_type_id" => 1,
                "authorization_number" => $admission['authorization_number'],
                "authorization_date" => $admission['authorization_date'],
                "appointment_id" => $admission['appointment_id'],
                'koneksi_claim_id' => $admission['koneksi_claim_id'],
                "invoice_id" => $invoiceId,
                "entity_id" => $admission['entity_id'],
                "entity_authorized_amount" => $admission['entity_authorized_amount'],

            ]);


            $this->appointmentService->changeStatus('pending_consultation', $admission['appointment_id']);



            $finalResponse = [];

            if ($invoice['type'] === 'entity') {

                $finalResponse = [
                    "invoice_code" => $invoiceCode,
                    "authorization_number" => $createdAdmission->authorization_number,
                    "authorization_date" => $createdAdmission->authorization_date
                ];
            } else if ($invoice['type'] === 'public') {

                if ($companyConsumerBilling) {
                    $finalResponse = [
                        "invoice_code" => $invoiceCode,
                        "invoice_reminder" => $invoiceReminder,
                        "resolution_number" => $companyConsumerBilling->resolution_number,
                        "resolution_date" => $companyConsumerBilling->resolution_date,
                        "expiration_date" => $companyConsumerBilling->expiration_date
                    ];
                }
            }

            return [
                "admission_data" => $createdAdmission,
                "data" => $finalResponse
            ];
        });
    }

    public function getAdmissionsByAppointmentId($id)
    {
        $admission = Admission::where('appointment_id', $id)->firstOrFail();

        try {
            $invoiceResponse = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post($this->baseUrl . "/invoices/find-by-field", [
                'field' => 'id',
                'value' => $admission->invoice_id
            ]);

            Log::info($invoiceResponse->json());

            if ($invoiceResponse->failed()) {
                $invoiceData = null;
            } else {
                $invoiceData = $invoiceResponse->json();
            }
        } catch (\Exception $e) {
            $invoiceData = null;
        }

        return [
            "admission" => $admission,
            "related_invoice" => $invoiceData
        ];
    }

    public function billingReport(array $data)
    {
        $admissions = Admission::query();
        $invoices = [];

        if (isset($data['entity_id'])) {
            $admissions->where('entity_id', $data['entity_id']);
        }

        if (isset($data['product_ids']) && count($data['product_ids']) > 0) {
            $productFilter = $data['product_ids'];
            $admissions->whereHas('appointment', function ($query) use ($productFilter) {
                $query->whereIn('product_id', $productFilter);
            });
        }

        if (isset($data['user_ids']) && count($data['user_ids']) > 0) {
            $userFilter = $data['user_ids'];
            $admissions->whereHas('appointment', function ($query) use ($userFilter) {
                $query->whereHas('assignedUserAvailability', function ($query) use ($userFilter) {
                    $query->whereHas('user', function ($query) use ($userFilter) {
                        $query->whereIn('id', $userFilter);
                    });
                });
            });
        }

        if (isset($data['patient_ids']) && count($data['patient_ids']) > 0) {
            $patientFilter = $data['patient_ids'];
            $admissions->whereHas('appointment', function ($query) use ($patientFilter) {
                $query->whereHas('patient', function ($query) use ($patientFilter) {
                    $query->whereIn('id', $patientFilter);
                });
            });
        }


        if (isset($data['start_date']) || isset($data['end_date'])) {
            $admissions->where(function ($query) use ($data) {
                if (isset($data['start_date'])) {
                    $query->whereDate('created_at', '>=', $data['start_date']);
                }
                if (isset($data['end_date'])) {
                    $query->whereDate('created_at', '<=', $data['end_date']);
                }
            });
        }

        $admissionsResponse = $admissions->get()->load([
            'user',
            'patient',
            'patient.socialSecurity.entity',
            'appointment.assignedUserAvailability.user'
        ]);

        $invoiceIds = $admissionsResponse->pluck('invoice_id')->toArray();

        $invoicesResponse = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($this->baseUrl . "/invoices/find/by-ids", ['invoice_ids' => $invoiceIds]);

        Log::info($invoicesResponse->json());

        if ($invoicesResponse->failed()) {
            throw new HttpResponseException(response()->json([
                'error' => 'Error al traer las facturas',
                'details' => $invoicesResponse->json() ?? 'Respuesta vacía del servidor'
            ], $invoicesResponse->status()));
        }

        $invoices = $invoicesResponse->json();

        return $admissionsResponse
            ->filter(function ($admission) use ($invoices) {
                $invoice = collect($invoices)->where('id', $admission->invoice_id)->first();
                return !is_null($invoice);
            })
            ->map(function ($admission) use ($invoices) {
                $admission->invoice = collect($invoices)->where('id', $admission->invoice_id)->first();
                $billingUser = $admission->user;
                $billingDoctor = $admission->appointment->assignedUserAvailability->user;
                $billingUserFullName = $billingUser->first_name . ' ' . $billingUser->middle_name . ' ' . $billingUser->last_name . ' ' . $billingUser->second_last_name;
                $billingDoctorFullName = $billingDoctor->first_name . ' ' . $billingDoctor->middle_name . ' ' . $billingDoctor->last_name . ' ' . $billingDoctor->second_last_name;

                return [
                    'billing_user' => $billingUserFullName,
                    'billing_doctor' => $billingDoctorFullName,
                    'patient' => $admission->patient,
                    'appointment_date_time' => [
                        'date' => $admission->appointment->appointment_date,
                        'time' => $admission->appointment->appointment_time,
                    ],
                    'invoice_date_time' => $admission->invoice['created_at'],
                    'authorization_number' => $admission->authorization_number,
                    'authorization_date' => $admission->authorization_date,
                    'billed_procedure' => $admission->invoice['details'],
                    'insurance' => $admission->entity,
                    'entity_authorized_amount' => $admission->entity_authorized_amount,
                    'type' => $admission->invoice['type'],
                    'invoice_consecutive' => [
                        'consecutive' => $admission->invoice['invoice_code'],
                        'resolution' => $admission->invoice['resolution_number'],
                    ],
                    'payment_methods' => $admission->invoice['payments'],
                    'invoice_status' => $admission->invoice['status'],
                ];
            })
            ->values()
            ->toArray();
    }

    public function billingReportByEntity(array $data)
    {
        $admissions = Admission::query();
        $invoices = [];

        if (isset($data['product_ids']) && count($data['product_ids']) > 0) {
            $productFilter = $data['product_ids'];
            $admissions->whereHas('appointment', function ($query) use ($productFilter) {
                $query->whereIn('product_id', $productFilter);
            });
        }

        if (isset($data['patient_ids']) && count($data['patient_ids']) > 0) {
            $patientFilter = $data['patient_ids'];
            $admissions->whereHas('appointment', function ($query) use ($patientFilter) {
                $query->whereHas('patient', function ($query) use ($patientFilter) {
                    $query->whereIn('id', $patientFilter);
                });
            });
        }

        $admissionsResponse = $admissions->get()->load([
            'user',
            'patient',
            'patient.socialSecurity.entity',
            'appointment.assignedUserAvailability.user'
        ]);

        $invoiceIds = $admissionsResponse->pluck('invoice_id')->toArray();

        $invoicesResponse = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($this->baseUrl . "/invoices/entity/find/with-filters", array_merge(["invoice_ids" => $invoiceIds], $data));

        Log::info($invoicesResponse->json());

        if ($invoicesResponse->failed()) {
            throw new HttpResponseException(response()->json([
                'error' => 'Error al traer las facturas',
                'details' => $invoicesResponse->json() ?? 'Respuesta vacía del servidor'
            ], $invoicesResponse->status()));
        }

        $invoices = $invoicesResponse->json();

        $userExternalIds = collect($invoices)->pluck('user_id')->unique()->filter()->values()->toArray();
        $users = User::whereIn('external_id', $userExternalIds)->get()->keyBy('external_id');

        return $admissionsResponse
            ->filter(function ($admission) use ($invoices) {
                $invoice = collect($invoices)->where('id', $admission->invoice_id)->first();
                return !is_null($invoice);
            })
            ->map(function ($admission) use ($invoices, $users) {
                $invoice = collect($invoices)->where('id', $admission->invoice_id)->first();
                $admission->invoice = $invoice;

                $user = collect($users)->where('external_id', $invoice['user_id'])->first();

                return [
                    'admission' => $admission,
                    'invoice' => $admission->invoice,
                    'user' => $user
                ];
            })
            ->values()
            ->toArray();
    }

    public function lastPatientInvoice(int $patientId)
    {
        $lastPatientAdmission = Admission::where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->first();
        if (!$lastPatientAdmission) {
            return response()->json([
                'error' => 'No se encontró ninguna admisión para el paciente'
            ], 404);
        }
        try {
            $invoiceResponse = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post($this->baseUrl . "/invoices/find-by-field", [
                'field' => 'id',
                'value' => $lastPatientAdmission->invoice_id
            ]);

            Log::info($invoiceResponse->json());

            if ($invoiceResponse->failed()) {
                $invoiceData = null;
            } else {
                $invoiceData = $invoiceResponse->json();
                $invoiceData['admission'] = $lastPatientAdmission;
            }
        } catch (\Exception $e) {
            $invoiceData = null;
        }
        return $invoiceData;
    }
}
