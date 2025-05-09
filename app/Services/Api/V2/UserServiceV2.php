<?php

namespace App\Services\Api\V2;

use App\Models\User;
use App\Exceptions\UserException;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class UserServiceV2
{
    public function __construct(private UserRepository $userRepository) {}

    public function getAllUsers($filters, $perPage)
    {
        try {
            return User::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new UserException('Failed to retrieve Users', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserById(User $user)
    {
        $result = $this->userRepository->find($user);
        if (!$result) {
            throw new UserException('User not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createUser(array $data)
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Exception $e) {
            throw new UserException('Failed to create User', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUser(User $user, array $data)
    {
        try {
            return $this->userRepository->update($user, $data);
        } catch (\Exception $e) {
            throw new UserException('Failed to update User', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUser(User $user)
    {
        try {
            return $this->userRepository->delete($user);
        } catch (\Exception $e) {
            throw new UserException('Failed to delete User', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}