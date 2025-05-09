<?php

namespace App\Services\Api\V2;

use App\Models\User;
use App\Models\UserAssistant;
use Illuminate\Http\Response;
use App\Exceptions\UserAssistantException;
use App\Repositories\UserAssistantRepository;

class UserAssistantServiceV2
{
    public function __construct(private UserAssistantRepository $userAssistantRepository) {}

    public function getAllUserAssistants($filters, $perPage)
    {
        try {
            return UserAssistant::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new UserAssistantException('Failed to retrieve UserAssistants', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserAssistantById(UserAssistant $userAssistant)
    {
        $result = $this->userAssistantRepository->find($userAssistant);
        if (!$result) {
            throw new UserAssistantException('UserAssistant not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createUserAssistant(array $data)
    {
        try {
            return $this->userAssistantRepository->create($data);
        } catch (\Exception $e) {
            throw new UserAssistantException('Failed to create UserAssistant', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function bulkCreateUserAssistants($supervisorUserId, array $assistantIds)
    {
        try {
            return $this->userAssistantRepository->bulkCreate($supervisorUserId, $assistantIds);
        } catch (\Exception $e) {
            throw new UserAssistantException('Failed to create UserAssistants', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserAssistant(UserAssistant $userAssistant, array $data)
    {
        try {
            return $this->userAssistantRepository->update($userAssistant, $data);
        } catch (\Exception $e) {
            throw new UserAssistantException('Failed to update UserAssistant', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUserAssistant(UserAssistant $userAssistant)
    {
        try {
            return $this->userAssistantRepository->delete($userAssistant);
        } catch (\Exception $e) {
            throw new UserAssistantException('Failed to delete UserAssistant', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAssistantsByUser(User $user)
    {
        return $user->assistants()->get();
    }
}
