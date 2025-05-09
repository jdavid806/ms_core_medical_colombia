<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admission;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AdmissionService;

use App\Services\AppointmentService;
use App\Repositories\AdmissionRepository;
use App\Http\Requests\Admission\UpdateAdmissionRequest;

class AdmissionController extends Controller
{
    protected $service;
    protected $repository;
    protected $relations = [
        'patient',
        'entity',
        'user'
    ];

    public function __construct(
        AdmissionService $service,
        private UserService $userService,
        private AppointmentService $appointmentService,
        AdmissionRepository $repository,
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index($patientId)
    {
        return $this->service->ofParent($patientId);
    }


    public function show($id)
    {
        $admission = Admission::find($id);
        $admission->load('patient', 'patient.socialSecurity.entity', 'patient.companions');

        return $admission;
    }

    public function showMultiple(Request $request)
    {
        // Validar que 'ids' es un array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        // Obtener los IDs del request
        $ids = $request->input('ids');

        // Llamar al método para obtener las citas y sus relaciones
        $admissions = $this->getAdmissionsByIds($ids);

        return response()->json(['admissions' => $admissions], 200);
    }

    private function getAdmissionsByIds(array $ids)
    {
        return Appointment::whereIn('id', $ids)->with([
            'patient',
            'patient.socialSecurity',
            'patient.companions',
            'appointmentState',
            'userAvailability.user',
            'assignedUserAvailability'
        ])->get();
    }


    // public function store(Request $request, int $patientId)
    // {

    //     try {

    //         // ✅ 1️⃣ Validar datos como en el microservicio admin
    //         $validatedData = Validator::make($data, [
    //             'external_id' => 'required|string|max:255',

    //             'admission' => 'required|array',
    //             'admission.authorization_number' => 'nullable|string|max:255',
    //             'admission.authorization_date' => 'nullable|date',
    //             'admission.appointment_id' => 'nullable|integer',
    //             'admission.cash_receipt_id' => 'nullable|integer',
    //             'admission.debit_note_id' => 'nullable|integer',
    //             'admission.credit_note_id' => 'nullable|integer',
    //             'admission.new_invoice_id' => 'nullable|integer',
    //             'admission.copayment' => 'nullable|boolean',
    //             'admission.moderator_fee' => 'nullable|boolean',


    //         ]);

    //         if ($validatedData->fails()) {
    //             throw new HttpResponseException(response()->json([
    //                 'error' => 'Validación fallida',
    //                 'details' => $validatedData->errors()
    //             ], 422));
    //         }

    //         DB::beginTransaction();

    //         // ✅ 2️⃣ Obtener usuario por external_id
    //         $user = $this->userService->getUserByExternalId($externalId);
    //         if (!$user) {
    //             throw new HttpResponseException(response()->json(['error' => 'Usuario no encontrado'], 404));
    //         }

    //         // ✅ 3️⃣ Asignar user_id al cash_receipt
    //         $cashReceiptData['user_id'] = $user->id;

    //         // ✅ 4️⃣ Desactivar la cita médica
    //         //$this->appointmentService->desactiveAppointment($appointmentId);

    //         // ✅ 5️⃣ Enviar la solicitud al microservicio para crear el cash_receipt
    //         $response = Http::post("http://dev.monaros.co/api/v1/admin/cash-receipts", [
    //             'type' => $cashReceiptData['type'],
    //             'status' => $cashReceiptData['status'],
    //             'subtotal' => $cashReceiptData['subtotal'],
    //             'discount' => $cashReceiptData['discount'] ?? 0,
    //             'iva' => $cashReceiptData['iva'] ?? 0,
    //             'total_amount' => $cashReceiptData['total_amount'],
    //             'observations' => $cashReceiptData['observations'] ?? null,
    //             'due_date' => $cashReceiptData['due_date'] ?? null,
    //             'paid_amount' => $cashReceiptData['paid_amount'],
    //             'remaining_amount' => $cashReceiptData['remaining_amount'],
    //             'quantity_total' => $cashReceiptData['quantity_total'],
    //             'user_id' => $cashReceiptData['user_id'],
    //             'details' => $cashReceiptDetailData,
    //             'payments' => $paymentsData ?? [],
    //         ]);


    //         // ✅ 6️⃣ Validar respuesta del microservicio
    //         if ($response->failed()) {
    //             throw new HttpResponseException(response()->json([
    //                 'error' => 'Error en la creación del recibo de caja',
    //                 'details' => $response->json() ?? 'Respuesta vacía del servidor'
    //             ], $response->status()));
    //         }

    //         // Log the current database connection
    //         Log::info('Current database connection: ' . DB::connection()->getDatabaseName());

    //         // Check if the table exists
    //         if (!Schema::hasTable('appointment_state_histories')) {
    //             Log::error('Table appointment_state_histories does not exist.');
    //             return response()->json(['error' => 'Table appointment_state_histories does not exist.'], 500);
    //         }

    //         $appointment = Appointment::find(5);
    //         if (!$appointment) {
    //             Log::error('Appointment not found.');
    //             return response()->json(['error' => 'Appointment not found.'], 404);
    //         }

    //         Log::info('Estado inicial: ' . $appointment->appointment_state_id);
    //         $appointment->update(['appointment_state_id' => 1]); // Se creará automáticamente el registro en el historial

    //         Log::info('Estado actualizado: ' . $appointment->appointment_state_id);

    //         return response()->json(['message' => 'Appointment state updated successfully.'], 200);
    //     } catch (Exception $e) {
    //         Log::error('Error: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal server error'], 500);
    //     }
    // }



    /* public function store(StoreAdmissionRequest $request, $patientId)
    {
        try {
            $admission = $this->service->createAdmission($request->validated(), $patientId);

           return $admission;
        } catch (\Throwable $th) {
            throw $th;
        }


    } */


    /* public function store(StoreAdmissionRequest $request, $patientId)
    {

        $admissionData = $request->input('admission'); // Ahora es un objeto, no un array
        $invoiceData = $request->input('invoice');
        $invoiceDetailData = $request->input('invoice_detail');
        $paymentsData = $request->input('payments');

        try {
            // Hacer la petición al microservicio con reintentos
            $response = Http::retry(3, 500)->post('http://dev.monaros.co/api/v1/admin/invoices/sales', [
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
            $admission = $this->service->createForParent($patientId, $admissionData);

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


    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }


    public function getAllAdmissions()
    {

        $today = Carbon::today()->toDateString();
        $admissions = Appointment::where('appointment_date', '>=', $today)->get();
        $admissions->load('patient', 'patient.socialSecurity.entity', 'userAvailability.user', 'assignedUserAvailability', 'appointmentState');

        return $admissions;
    }

    public function newStore(Request $request, $patientId)
    {

        //dd($request->all());
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        return $this->service->newCreateAdmission($request->all(), $patientId);
    }

    public function getAdmissionsByAppointmentId($appointmentId)
    {
        $data = $this->service->getAdmissionsByAppointmentId($appointmentId);
        $admission = $data['admission'];
        $admission->load(
            'patient',
            'patient.socialSecurity.entity',
            'user',
            'appointment'
        );
        return $data;
    }

    public function billingReport(Request $request)
    {
        $data = $this->service->billingReport($request->all());
        return $data;
    }

    public function billingReportByEntity(Request $request)
    {
        $data = $this->service->billingReportByEntity($request->all());
        return $data;
    }

    public function lastPatientInvoice($patientId)
    {
        $data = $this->service->lastPatientInvoice($patientId);
        return $data;
    }
}
