<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IntegrationCredential;
use App\Filters\IntegrationCredentialFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\IntegrationCredentialService;
use App\Http\Resources\Api\V1\IntegrationCredential\IntegrationCredentialResource;
use App\Http\Requests\Api\V1\IntegrationCredential\StoreIntegrationCredentialRequest;
use App\Http\Requests\Api\V1\IntegrationCredential\UpdateIntegrationCredentialRequest;

class IntegrationCredentialControllerV1 extends ApiController
{
    public function __construct(private IntegrationCredentialService $integrationCredentialService) {}

    public function index(IntegrationCredentialFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $integrationCredentials = $this->integrationCredentialService->getAllIntegrationCredentials($filters, $perPage);

        return $this->ok('IntegrationCredentials retrieved successfully', IntegrationCredentialResource::collection($integrationCredentials));
    }

    public function store(StoreIntegrationCredentialRequest $request)
    {
        $integrationCredential = $this->integrationCredentialService->createIntegrationCredential($request->validated());
        return $this->ok('IntegrationCredential created successfully', new IntegrationCredentialResource($integrationCredential));
    }

    public function show(IntegrationCredential $integrationCredential)
    {
        if($this->include('integration')) {
            $integrationCredential->load('integration');
        }
        return $this->ok('IntegrationCredential retrieved successfully', new IntegrationCredentialResource($integrationCredential));
    }

    public function update(UpdateIntegrationCredentialRequest $request, IntegrationCredential $integrationCredential)
    {

        $this->integrationCredentialService->updateIntegrationCredential($integrationCredential, $request->validated());
        return $this->ok('IntegrationCredential updated successfully');
    }

    public function destroy(IntegrationCredential $integrationCredential)
    {
        $this->integrationCredentialService->deleteIntegrationCredential($integrationCredential);
        return $this->ok('IntegrationCredential deleted successfully');
    }
}