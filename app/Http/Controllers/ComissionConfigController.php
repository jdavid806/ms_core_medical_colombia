<?php

namespace App\Http\Controllers;

use App\Models\ComissionConfig;
use App\Services\ComissionConfigService;
use App\Models\ComissionConfigService as ComissionConfigServiceModel;
use App\Models\User;
use App\Services\ComissionConfigServiceService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ComissionConfigController extends BasicController
{
    protected $service;
    protected $userService;
    protected $productService;
    protected $relations = ['patient'];
    protected $baseUrl;

    public function __construct(ComissionConfigService $service, ComissionConfigServiceService $productService)
    {
        $this->service = $service;
        $this->productService = $productService;
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo.localhost:8001/api/v1/admin');
    }

    public function index()
    {
        return $this->service->getComissions();
    }

    public function show($id)
    {
        return $this->service->getComissionById($id);
    }

    public function store(Request $request)
    {

        // Create comission config
        if (is_array($request->users) && !empty($request->users)) {
            foreach ($request->users as $user) {
                $data = [
                    'attention_type' => $request->attention_type,
                    'application_type' => $request->application_type,
                    'commission_type' => $request->commission_type,
                    'percentage_base' => $request->percentage_base,
                    'percentage_value' => $request->percentage_value,
                    'commission_value' => $request->commission_value,
                    'user_id' => $user,
                ];
                $response = $this->service->create($data);
                // Create comission config for services
                if (is_array($request->services) && !empty($request->services)) {
                    foreach ($request->services as $service) {
                        ComissionConfigServiceModel::whereHas('comissionConfig', function ($query) use ($response, $user) {
                            $query->where('attention_type', $response->attention_type)->where('user_id', $user);
                        })->where('service_id', $service)->delete();
                        $requestComissionServiceConfig = ["service_id" => $service, "commission_config_id" => $response->id];
                        $this->productService->create($requestComissionServiceConfig);
                    }
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        ComissionConfigServiceModel::where('commission_config_id', $id)->delete();
        $finalRequest = [
            'attention_type' => $request->attention_type,
            'application_type' => $request->application_type,
            'commission_type' => $request->commission_type,
            'percentage_base' => $request->percentage_base,
            'percentage_value' => $request->percentage_value,
            'commission_value' => $request->commission_value,
            'user_id' => $request->users[0],
        ];
        foreach ($request->services as $service) {
            $requestComissionServiceConfig = ["service_id" => $service, "commission_config_id" => $id];
            $this->productService->create($requestComissionServiceConfig);
        }
        return $this->service->update($id, $finalRequest);
    }

    public function destroy($id)
    {
        ComissionConfigServiceModel::where('commission_config_id', $id)->delete();
        ComissionConfig::where('id', $id)->delete();
    }

    public function commissionByServiceReport(Request $request)
    {
        // Consulta base de usuarios
        $users = User::whereHas('role', function ($query) {
            $query->where('group', 'DOCTOR');
        })
            ->when(count($request->user_ids) > 0, function ($query) use ($request) {
                $query->whereIn('id', $request->user_ids);
            })
            ->with(['commissions.services'])
            ->get();

        // Cargar admisiones con condiciones
        $users->load(['admissions' => function ($query) use ($request) {
            $query->when(count($request->entity_ids) > 0, function ($query) use ($request) {
                $query->whereIn('entity_id', $request->entity_ids);
            })
                ->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ])
                ->whereHas('appointment', function ($query) use ($request) {
                    $query->when(count($request->service_ids) > 0, function ($query) use ($request) {
                        $query->whereIn('product_id', $request->service_ids);
                    });
                })
                ->with(['appointment']);
        }]);

        // Obtener IDs de facturas y productos
        $invoiceIds = [];
        $products = collect($this->service->repository->fetchProducts())->keyBy('id');

        foreach ($users as $user) {
            foreach ($user->admissions as $admission) {
                $invoiceIds[] = $admission->invoice_id;
                $admission->appointment->product = $products[$admission->appointment->product_id] ?? null;
            }
        }

        // Obtener facturas desde API externa
        $invoicesResponse = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($this->baseUrl . "/invoices/find/by-ids", [
            'invoice_ids' => array_unique($invoiceIds)
        ]);

        if ($invoicesResponse->failed()) {
            Log::error('Error al obtener facturas', [
                'status' => $invoicesResponse->status(),
                'response' => $invoicesResponse->json()
            ]);

            throw new HttpResponseException(response()->json([
                'error' => 'Error al obtener las facturas',
                'details' => $invoicesResponse->json() ?? 'Respuesta vacía del servidor'
            ], $invoicesResponse->status()));
        }

        $invoices = collect($invoicesResponse->json())->keyBy('id');

        // Asignar facturas a usuarios
        foreach ($users as $user) {
            $user->invoices = $user->admissions->map(function ($admission) use ($invoices) {
                return $invoices[$admission->invoice_id] ?? null;
            })->filter()->values()->toArray();
        }

        return response()->json($users);
    }
}
