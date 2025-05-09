<?php

namespace App\Services;

use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\PrescriptionRepository;

class PrescriptionService
{
    protected string $baseUrl;

    public function __construct(private PrescriptionRepository $prescriptionRepository, private PrescriptionDetailService $prescriptionDetailService) 
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo2.localhost:8000/api/v1/admin');
    }

    public function getAllPrescriptions()
    {
        return $this->prescriptionRepository->all();
    }

    public function getPrescriptionById(Prescription $prescription)
    {
        return $this->prescriptionRepository->find($prescription);
    }

    public function createPrescription(array $data)
    {
        try {
            DB::beginTransaction();
    
            // Crear la receta
            $prescription = $this->prescriptionRepository->create($data);
    
            // Iterar sobre los medicamentos y crear cada uno
            foreach ($data['medicines'] as $medicine) {
                // 1. Verificar stock en microservicio
                $stockCheck = Http::get("{$this->baseUrl}/product/{$medicine['product_service_id']}/stock");
    
                // Verificar primero si la petición HTTP falló
                if (!$stockCheck->successful()) {
                    DB::rollBack();
                    throw new \Exception('Error al consultar el stock para el producto: ' . $medicine['product_service_id'] . '. Código de estado: ' . $stockCheck->status());
                }
    
                // Obtener el stock como entero
                $currentStock = (int)$stockCheck->body();
    
                // Validar stock
                if ($currentStock < $medicine['quantity']) {
                    DB::rollBack();
                    throw new \Exception("Stock insuficiente para el producto {$medicine['product_service_id']}. Disponible: $currentStock, Solicitado: {$medicine['quantity']}");
                }
    
                // 2. Crear detalle
                $medicine['prescription_id'] = $prescription->id; // Asegúrate de añadir el ID de la receta a los datos del medicamento
                $this->prescriptionDetailService->createPrescriptionDetail($medicine);
    
                // 3. Actualizar stock en microservicio
                $stockUpdate = Http::patch("{$this->baseUrl}/product/{$medicine['product_service_id']}/decrement", [
                    'quantity' => $medicine['quantity']
                ]);
    
                if (!$stockUpdate->successful()) {
                    DB::rollBack();
                    throw new \Exception('Error al actualizar el stock para el producto: ' . $medicine['product_service_id']);
                }
            }
    
            DB::commit();
            return $prescription;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Transaction failed: ' . $e->getMessage());
        }
    }
    

    public function updatePrescription(Prescription $prescription, array $data)
    {
        return $this->prescriptionRepository->update($prescription, $data);
    }

    public function deletePrescription(Prescription $prescription)
    {
        return $this->prescriptionRepository->delete($prescription);
    }
}
