<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepository;

class CountryService
{
    public function __construct(private CountryRepository $countryRepository) {}

    public function getAllCountries()
    {
        return $this->countryRepository->getAllCountries();
    }

    public function getCountryById(Country $country)
    {
        return $this->countryRepository->find($country);
    }

    public function createCountry(array $data)
    {
        return $this->countryRepository->create($data);
    }

    public function updateCountry(Country $country, array $data)
    {
        return $this->countryRepository->update($country, $data);
    }

    public function deleteCountry(Country $country)
    {
        return $this->countryRepository->delete($country);
    }
}
