<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Country\CountryResource;
use App\Http\Requests\Api\V1\Country\StoreCountryRequest;
use App\Http\Requests\Api\V1\Country\UpdateCountryRequest;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService) {}

    public function index()
    {
        $countries = $this->countryService->getAllCountries();
        return CountryResource::collection($countries);
    }

    


}
