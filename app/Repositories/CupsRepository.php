<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CupsRepository extends BaseRepository
{
    public function getAllCups()
    {
        return DB::connection('central_connection')
            ->table('cups')
            ->get();
    }

    public function getByCode($code)
    {
        $query = DB::connection('central_connection')
            ->table('cups');

        if ($code) {
            $query->where('Codigo', $code);
        }

        return $query->get();
    }

    public function getByName($name)
    {
        $query = DB::connection('central_connection')
            ->table('cups');

        if ($name) {
            $query->where('Nombre', $name);
        }

        return $query->get();
    }
}
