<?php

namespace App\Services\Api\V1;

use App\Models\Integration;
use App\Exceptions\IntegrationException;
use App\Repositories\IntegrationRepository;
use Illuminate\Http\Response;

class IntegrationService
{
    public function __construct(private IntegrationRepository $integrationRepository) {}

    public function getAllIntegrations($filters, $perPage)
    {
        try {
            return Integration::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new IntegrationException('Failed to retrieve Integrations', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getIntegrationById(Integration $integration)
    {
        $result = $this->integrationRepository->find($integration);
        if (!$result) {
            throw new IntegrationException('Integration not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createIntegration(array $data)
    {
        try {
            return $this->integrationRepository->create($data);
        } catch (\Exception $e) {
            throw new IntegrationException('Failed to create Integration', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateIntegration(Integration $integration, array $data)
    {
        try {
            return $this->integrationRepository->updateModel($integration, $data);
        } catch (\Exception $e) {
            throw new IntegrationException('Failed to update Integration', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteIntegration(Integration $integration)
    {
        try {
            return $this->integrationRepository->deleteModel($integration);
        } catch (\Exception $e) {
            throw new IntegrationException('Failed to delete Integration', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}