<?php

namespace App\Services;

use App\Repositories\CupsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CupsService
{
    //public function __construct(private CupsRepository $cupsRepository) {}
    public function getCups()
    {
        Log::info('getCups');
        try {
            $result = DB::connection('central_connection')
                ->table('cups')
                ->paginate(10); // Cambia 10 por el número de registros que quieres obtener por página
            Log::info('Consulta exitosa', ['result' => $result]);
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error en la consulta', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
        Log::info('getCups');
    }


    function getByCode($code)
    {
        return DB::connection('central_connection')
            ->table('cups')
            ->where('Codigo', $code)
            ->get();
    }

    function getByName($code)
    {

        return DB::connection('central_connection')
        ->table('cups')
        ->where('Nombre', $code)
        ->get();
    }
}
