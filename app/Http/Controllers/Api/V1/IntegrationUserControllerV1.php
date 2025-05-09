<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IntegrationUser;
use App\Filters\IntegrationUserFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\IntegrationUserService;
use App\Http\Resources\Api\V1\IntegrationUser\IntegrationUserResource;
use App\Http\Requests\Api\V1\IntegrationUser\StoreIntegrationUserRequest;
use App\Http\Requests\Api\V1\IntegrationUser\UpdateIntegrationUserRequest;

class IntegrationUserControllerV1 extends ApiController
{
    public function __construct(private IntegrationUserService $integrationUserService) {}

    public function index(IntegrationUserFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $integrationUsers = $this->integrationUserService->getAllIntegrationUsers($filters, $perPage);

        return $this->ok('IntegrationUsers retrieved successfully', IntegrationUserResource::collection($integrationUsers));
    }

    public function store(StoreIntegrationUserRequest $request)
    {
        $integrationUser = $this->integrationUserService->createIntegrationUser($request->validated());
        return $this->ok('IntegrationUser created successfully', new IntegrationUserResource($integrationUser));
    }

    public function show(IntegrationUser $integrationUser)
    {
        return $this->ok('IntegrationUser retrieved successfully', new IntegrationUserResource($integrationUser));
    }

    public function update(UpdateIntegrationUserRequest $request, IntegrationUser $integrationUser)
    {
        $this->integrationUserService->updateIntegrationUser($integrationUser, $request->validated());
        return $this->ok('IntegrationUser updated successfully');
    }

    public function destroy(IntegrationUser $integrationUser)
    {
        $this->integrationUserService->deleteIntegrationUser($integrationUser);
        return $this->ok('IntegrationUser deleted successfully');
    }
}