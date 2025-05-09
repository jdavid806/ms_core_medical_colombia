<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Integration;
use App\Filters\IntegrationFilter;
use App\Services\Api\V1\IntegrationService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\Integration\IntegrationResource;
use App\Http\Requests\Api\V1\Integration\StoreIntegrationRequest;
use App\Http\Requests\Api\V1\Integration\UpdateIntegrationRequest;

class IntegrationControllerV1 extends ApiController
{
    public function __construct(private IntegrationService $integrationService) {}

    public function index(IntegrationFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $integrations = $this->integrationService->getAllIntegrations($filters, $perPage);

        return $this->ok('Integrations retrieved successfully', IntegrationResource::collection($integrations));
    }

    public function store(StoreIntegrationRequest $request)
    {
        $integration = $this->integrationService->createIntegration($request->validated());
        return $this->ok('Integration created successfully', new IntegrationResource($integration));
    }

    public function show(Integration $integration)
    {
        if($this->include('credentials')) {
            $integration->load('credentials');
        }
        return $this->ok('Integration retrieved successfully', new IntegrationResource($integration));
    }

    public function update(UpdateIntegrationRequest $request, Integration $integration)
    {
        $this->integrationService->updateIntegration($integration, $request->validated());
        return $this->ok('Integration updated successfully');
    }

    public function destroy(Integration $integration)
    {
        $this->integrationService->deleteIntegration($integration);
        return $this->ok('Integration deleted successfully');
    }
}