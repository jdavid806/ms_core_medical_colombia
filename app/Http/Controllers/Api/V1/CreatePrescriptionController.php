<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CreatePrescriptionController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'patient_id' => 'required|integer',
            'user_id' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'medicines' => 'required|array|min:1',
            'medicines.*.product_service_id' => 'required|string',
            'medicines.*.dosis' => 'required|string',
            'medicines.*.via' => 'required|string',
            'medicines.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $prescription = Prescription::create([
                'patient_id' => $validated['patient_id'],
                'user_id' => $validated['user_id'],
                'is_active' => $validated['is_active'] ?? true
            ]);

            foreach ($validated['medicines'] as $medicine) {
                // 1. Verificar stock en microservicio
                $stockCheck = Http::get("http://consultorio2.medicalsoft.ai/api/v1/admin/products/{$medicine['product_service_id']}/stock");
                
                if (!$stockCheck->successful() || $stockCheck->json('stock') < $medicine['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'error' => 'Insufficient stock for product: ' . $medicine['product_service_id']
                    ], 422);
                }

                // 2. Crear detalle
                $detail = $prescription->details()->create([
                    'product_service_id' => $medicine['product_service_id'],
                    'dosis' => $medicine['dosis'],
                    'via' => $medicine['via'],
                    'frequency' => $medicine['frequency'] ?? null,
                    'form' => $medicine['form'] ?? null,
                    'type' => $medicine['type'] ?? null,
                    'duration' => $medicine['duration'] ?? null,
                    'instructions' => $medicine['instructions'] ?? null,
                    'quantity' => $medicine['quantity']
                ]);

                // 3. Actualizar stock en microservicio
                $stockUpdate = Http::patch("https://admin-service/api/products/{$medicine['product_service_id']}/decrement", [
                    'quantity' => $medicine['quantity']
                ]);

                if (!$stockUpdate->successful()) {
                    DB::rollBack();
                    return response()->json([
                        'error' => 'Stock update failed for product: ' . $medicine['product_service_id']
                    ], 500);
                }
            }

            DB::commit();
            return response()->json($prescription->load('details'), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Transaction failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
