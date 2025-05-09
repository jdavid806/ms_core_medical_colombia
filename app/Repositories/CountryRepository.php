<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Country $country)
    {
        parent::__construct($country, self::RELATIONS);
    }


    // Ejemplo para countries (replicar para states/cities)
    public function getAllCountries()
    {
        return DB::connection('central_connection')
            ->table('countries')
            ->select('id', 'name', 'iso2', 'phonecode') // Solo columnas necesarias
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })->toArray();
    }
    
}
