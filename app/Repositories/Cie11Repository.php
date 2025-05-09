<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Cie11Repository extends BaseRepository
{

    public function getByCode($code)
    {
        $query = DB::connection('central_connection')
            ->table('cie11');

        if ($code) {
            $query->where('codigo', $code);
        }

        return $query->get();
    }

    public function getByName($name)
    {
        $query = DB::connection('central_connection')
            ->table('cie11');

        if ($name) {
            $query->where('descripcion', $name);
        }

        return $query->get();
    }
}
