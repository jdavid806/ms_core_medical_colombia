<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Billing;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\BillingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Billing\BillingResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    protected $msAdminUrl;

    public function __construct(private BillingService $billingService)
    {
        $this->msAdminUrl = env('INVENTORY_SERVICE_URL', 'http://foo.localhost:8001/api/v1/admin');
    }

    public function index()
    {
        $billings = $this->billingService->getAllBillings();
        return BillingResource::collection($billings);
    }

    public function store(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'dian_prefix' => 'required|string|max:20',
            'resolution_number' => 'required|string|max:50',
            'invoice_from' => 'required|integer|min:0',
            'invoice_to' => 'required|integer|min:0|gt:invoice_from',
            'resolution_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:resolution_date',
            'type' => 'required|string',
        ]);

        $validatedData['company_id'] = $company->id;

        $billing = Billing::create($validatedData);

        return response()->json([
            'message' => 'Billing record created successfully',
            'billing' => $billing,
        ], 201);
    }


    public function show(Company $company, Billing $billing)
    {
        if ($billing->company_id !== $company->id) {
            return response()->json([
                'message' => 'This billing does not belong to the specified company',
            ], 404);
        }

        return response()->json($billing);
    }


    public function update(Request $request, Company $company, Billing $billing)
    {
        if ($billing->company_id !== $company->id) {
            return response()->json([
                'message' => 'This billing does not belong to the specified company',
            ], 404);
        }

        $validatedData = $request->validate([
            'dian_prefix' => 'string|max:20',
            'resolution_number' => 'string|max:50',
            'invoice_from' => 'integer|min:0',
            'invoice_to' => 'integer|min:0|gt:invoice_from',
            'resolution_date' => 'date',
            'expiration_date' => 'date|after_or_equal:resolution_date',
            'type' => 'string',
        ]);

        $billing->update($validatedData);

        return response()->json([
            'message' => 'Billing record updated successfully',
            'billing' => $billing,
        ]);
    }


    public function destroy(Company $company, Billing $billing)
    {
        if ($billing->company_id !== $company->id) {
            return response()->json([
                'message' => 'This billing does not belong to the specified company',
            ], 404);
        }

        $billing->delete();

        return response()->json([
            'message' => 'Billing record deleted successfully',
        ]);
    }

    public function storeInvoiceByEntity(Request $request)
    {
        $data = $request->all();

        return DB::transaction(function () use ($data) {

            $invoice = $data['invoice'];
            $billingType = $data['billing_type'];

            $invoice['user_id'] = $data['external_id'];

            $company = Company::all()->first();
            $company->load('billings');
            $companyConsumerBilling = $company->billings->where('type', $billingType)->first();

            $nextResolutionCodeResponse = Http::withHeaders([
                'Accept' => 'application/json'
            ])->get(
                $this->msAdminUrl . "/invoices/next/resolution-invoice-code/" . $companyConsumerBilling->resolution_number
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

            $invoice['invoice_code'] = $invoiceCode;

            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post(
                $this->msAdminUrl . "/invoices/sales/by-entity",
                [
                    'child_invoice_ids' => $data['child_invoice_ids'],
                    'tax_charge' => $data['tax_charge'],
                    'withholding_tax' => $data['withholding_tax'],
                    'invoice' => $invoice,
                    'invoice_detail' => $data['invoice_detail'],
                    'payments' => $data['payments'],
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

            return response()->json($createdInvoice);
        });
    }
}
