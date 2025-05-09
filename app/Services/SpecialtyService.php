<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response as HttpResponse;

class SpecialtyService
{
    public function getSpecialties()
    {
        try {
            return DB::connection('central_connection')
                ->table('specialities')
                ->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSpecialtyById(int $id)
    {
        return DB::connection('central_connection')
            ->table('specialities')
            ->where('id', $id)
            ->first();
    }
}
