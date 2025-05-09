<?php

namespace App\Services;

use App\Models\City;
use App\Repositories\CityRepository;

class CityService
{
    public function __construct(private CityRepository $cityRepository) {}

    public function getAllCities()
    {
        return $this->cityRepository->all();
    }

    public function getCityById(City $city)
    {
        return $this->cityRepository->find($city);
    }

    public function createCity(array $data)
    {
        return $this->cityRepository->create($data);
    }

    public function updateCity(City $city, array $data)
    {
        return $this->cityRepository->update($city, $data);
    }

    public function deleteCity(City $city)
    {
        return $this->cityRepository->delete($city);
    }

    public function getCitiesByDepartment($department)
    {
        return $this->cityRepository->getCitiesByState($department);
    }

    public function getCitiesByCountry($country)
    {
        return $this->cityRepository->getCitiesByCountry($country);
    }
}
