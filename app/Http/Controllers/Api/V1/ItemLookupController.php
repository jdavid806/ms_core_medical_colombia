<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class ItemLookupController extends Controller
{

    public function __construct(private InvoiceService $invoiceService) {}
    /* public function show($type, $id)
    {
        // Lista de modelos permitidos
        $allowedModels = [
            'Examen' => 'App\\Models\\ExamOrder',
            'Incapacidad' => 'App\\Models\\PatientDisability',
            'Remision' => 'App\\Models\\Remission',
        ];

        if (!array_key_exists($type, $allowedModels)) {
            return response()->json([
                'message' => "El modelo '{$type}' no está permitido.",
            ], 400);
        }

        // Obtener el modelo correspondiente
        $modelClass = $allowedModels[$type];


        // Buscar el registro
        $item = $modelClass::find($id);

        if (!$item) {
            return response()->json([
                'message' => "El registro con ID {$id} no existe en el modelo {$type}.",
            ], 404);
        }

        return response()->json($item, 200);
    } */


    public function showOrCreate(Request $request, $type)
    {
        // Lista de modelos permitidos
        $allowedModels = [
            'Incapacidad' => 'App\\Models\\PatientDisability',
            'Remision' => 'App\\Models\\Remission',
        ];
    
        if (!array_key_exists($type, $allowedModels)) {
            return response()->json([
                'message' => "El modelo '{$type}' no está permitido.",
            ], 400);
        }
    
        // Obtener el modelo correspondiente
        $modelClass = $allowedModels[$type];
    
    
        // Caso 2: Si es 'Incapacidad' o 'Remision', recibir datos del microservicio admin y crear instancia
        $validatedData = $request->validate([
            'prescriptions' => ['required', 'array'], // Datos necesarios para la creación
        ]);
    
        $newItem = $modelClass::create($validatedData['prescriptions']);
    
        return response()->json([
            'message' => "Registro creado correctamente en el modelo {$type}.",
            'id' => $newItem->id,
            'data' => $newItem
        ], 201);
    }
    
    
}
