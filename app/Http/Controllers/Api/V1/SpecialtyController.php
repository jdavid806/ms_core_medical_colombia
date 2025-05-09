<?php

namespace App\Http\Controllers\Api\V1;


use App\Services\SpecialtyService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response as HttpResponse;

class SpecialtyController extends Controller
{
    public function __construct(private SpecialtyService $specialtyService) {}
    public function index()
    {
        try {
            return $this->specialtyService->getSpecialties();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
