<?php

namespace App\Http\Controllers\Api\V1;



use Carbon\Carbon;


use App\Models\Tenant;
use App\Models\Company;
use App\Models\Patient;
use App\Models\AiResponse;
use App\Models\Appointment;
use App\Models\ChronicCondition;
use App\Filters\AiResponseFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Api\V1\AiResponseService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\AiResponse\AiResponseResource;
use App\Http\Requests\Api\V1\AiResponse\StoreAiResponseRequest;
use App\Http\Requests\Api\V1\AiResponse\UpdateAiResponseRequest;

class AiResponseController extends ApiController
{
    public function __construct(private AiResponseService $aiResponseService) {}

    public function index(AiResponseFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $aiResponses = $this->aiResponseService->getAllAiResponses($filters, $perPage);

        return $this->ok('AiResponses retrieved successfully', AiResponseResource::collection($aiResponses));
    }

    public function store(StoreAiResponseRequest $request)
    {

        $aiResponse = $this->aiResponseService->createAiResponse($request->validated());
        return $this->ok('AiResponse created successfully', new AiResponseResource($aiResponse));
    }

    public function show(AiResponse $aiResponse)
    {
        return $this->ok('AiResponse retrieved successfully', new AiResponseResource($aiResponse));
    }

    public function update(UpdateAiResponseRequest $request, AiResponse $aiResponse)
    {
        $this->aiResponseService->updateAiResponse($aiResponse, $request->validated());
        return $this->ok('AiResponse updated successfully');
    }

    public function destroy(AiResponse $aiResponse)
    {
        $this->aiResponseService->deleteAiResponse($aiResponse);
        return $this->ok('AiResponse deleted successfully');
    }

}
