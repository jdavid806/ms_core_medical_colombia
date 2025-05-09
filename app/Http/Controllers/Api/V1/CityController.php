<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\City;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\City\CityResource;
use App\Http\Requests\Api\V1\City\StoreCityRequest;
use App\Http\Requests\Api\V1\City\UpdateCityRequest;

class CityController extends Controller
{
    public function __construct(private CityService $cityService) {}

    public function index()
    {

        $cities = $this->cityService->getAllCities();
        return CityResource::collection($cities);
    }

    public function store(StoreCityRequest $request)
    {
        $city = $this->cityService->createCity($request->validated());
        return response()->json([
            'message' => 'City created successfully',
            'City' => $city,
        ]);
    }

    public function show(City $city)
    {
        return new CityResource($city);
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $this->cityService->updateCity($city, $request->validated());
        return response()->json([
            'message' => 'City updated successfully',
        ]);
    }

    public function destroy(City $city)
    {
        $this->cityService->deleteCity($city);
        return response()->json([
            'message' => 'City deleted successfully',
        ]);
    }

    public function citiesByDepartment($department)
    {
        return $this->cityService->getCitiesByDepartment($department);
    }

    public function citiesByCountry($country)
    {
        return $this->cityService->getCitiesByCountry($country);
    }
}
