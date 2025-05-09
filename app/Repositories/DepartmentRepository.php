<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Department $department)
    {
        parent::__construct($department, self::RELATIONS);
    }

    public function getDepartmentsByCountry($countryId,) {
        return DB::connection('central_connection')
            ->table('states')
            ->select('id', 'name', 'country_id')
            ->where('country_id', $countryId) // Filtra por departamento
            ->get();
    }
}
