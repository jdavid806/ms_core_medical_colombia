<?php

namespace App\Services\Api\V1;

use App\Models\IntegrationUser;
use App\Exceptions\IntegrationUserException;
use App\Repositories\IntegrationUserRepository;
use Illuminate\Http\Response;

class IntegrationUserService
{
    public function __construct(private IntegrationUserRepository $integrationUserRepository) {}

    public function getAllIntegrationUsers($filters, $perPage)
    {
        try {
            return IntegrationUser::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new IntegrationUserException('Failed to retrieve IntegrationUsers', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getIntegrationUserById(IntegrationUser $integrationUser)
    {
        $result = $this->integrationUserRepository->find($integrationUser);
        if (!$result) {
            throw new IntegrationUserException('IntegrationUser not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createIntegrationUser(array $data)
    {
        try {
            return $this->integrationUserRepository->create($data);
        } catch (\Exception $e) {
            throw new IntegrationUserException('Failed to create IntegrationUser', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateIntegrationUser(IntegrationUser $integrationUser, array $data)
    {
        try {
            return $this->integrationUserRepository->update($integrationUser, $data);
        } catch (\Exception $e) {
            throw new IntegrationUserException('Failed to update IntegrationUser', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteIntegrationUser(IntegrationUser $integrationUser)
    {
        try {
            return $this->integrationUserRepository->delete($integrationUser);
        } catch (\Exception $e) {
            throw new IntegrationUserException('Failed to delete IntegrationUser', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}