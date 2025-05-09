<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(City $city)
    {
        parent::__construct($city, self::RELATIONS);
    }

    public function all()
    {
        return DB::connection('central_connection')
            ->table('cities')
            ->select('id', 'name', 'state_id')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })->toArray();
    }

    public function getCitiesByState($stateId)
    {
        return DB::connection('central_connection')
            ->table('cities')
            ->select('id', 'name', 'state_id')
            ->where('state_id', $stateId) // Filtra por departamento
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })->toArray();
    }

    public function getCitiesByCountry($countryId)
    {
        return DB::connection('central_connection')
            ->table('cities')
            ->select('id', 'name', 'country_id')
            ->where('country_id', $countryId)
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })->toArray();
    }
}
