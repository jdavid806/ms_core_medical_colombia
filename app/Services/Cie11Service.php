<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Cie11Service
{

    function getByCode($code)
    {
        return DB::connection('central_connection')
            ->table('cie11')
            ->where('codigo', $code)
            ->get();
    }

    function getByName($code)
    {

        return DB::connection('central_connection')
        ->table('cie11')
        ->where('descripcion', $code)
        ->get();
    }
}
