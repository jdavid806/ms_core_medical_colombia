<?php

namespace App\Services\Api\V1;

use App\Models\IntegrationCredential;
use App\Exceptions\IntegrationCredentialException;
use App\Repositories\IntegrationCredentialRepository;
use Illuminate\Http\Response;

class IntegrationCredentialService
{
    public function __construct(private IntegrationCredentialRepository $integrationCredentialRepository) {}

    public function getAllIntegrationCredentials($filters, $perPage)
    {
        try {
            return IntegrationCredential::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new IntegrationCredentialException('Failed to retrieve IntegrationCredentials', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getIntegrationCredentialById(IntegrationCredential $integrationCredential)
    {
        $result = $this->integrationCredentialRepository->find($integrationCredential);
        if (!$result) {
            throw new IntegrationCredentialException('IntegrationCredential not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createIntegrationCredential(array $data)
    {
        try {
            return $this->integrationCredentialRepository->create($data);
        } catch (\Exception $e) {
            throw new IntegrationCredentialException('Failed to create IntegrationCredential', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateIntegrationCredential(IntegrationCredential $integrationCredential, array $data)
    {
        try {
            return $this->integrationCredentialRepository->updateModel($integrationCredential, $data);
        } catch (\Exception $e) {
            throw new IntegrationCredentialException('Failed to update IntegrationCredential', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteIntegrationCredential(IntegrationCredential $integrationCredential)
    {
        try {
            return $this->integrationCredentialRepository->deleteModel($integrationCredential);
        } catch (\Exception $e) {
            throw new IntegrationCredentialException('Failed to delete IntegrationCredential', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}