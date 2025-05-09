<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\CupsService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CupsController extends Controller
{
    public function __construct(private CupsService $cupsService) {}

    public function index($perPage = 10)
    {
        try {
            return DB::connection('central_connection')
                ->table('cups')
                ->select('id', 'Codigo', 'Nombre')
                ->paginate($perPage);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByCode($code)
    {
        return $this->cupsService->getByCode($code);
    }
    public function getByName($name)
    {
        return $this->cupsService->getByName($name);
    }
}
