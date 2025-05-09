<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\User;
use App\Filters\UserFilter;
use App\Services\Api\V2\UserServiceV2;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V2\User\UserResourceV2;
use App\Http\Requests\Api\V2\User\StoreUserRequestV2;
use App\Http\Requests\Api\V2\User\UpdateUserRequestV2;

class UserControllerV2 extends ApiController
{
    public function __construct(private UserServiceV2 $userService) {}

    public function index(UserFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $users = $this->userService->getAllUsers($filters, $perPage);

        return $this->ok('Users retrieved successfully', UserResourceV2::collection($users));
    }

    public function store(StoreUserRequestV2 $request)
    {
        $user = $this->userService->createUser($request->validated());
        return $this->ok('User created successfully', new UserResourceV2($user));
    }

    public function show(User $user)
    {
        return $this->ok('User retrieved successfully', new UserResourceV2($user));
    }

    public function update(UpdateUserRequestV2 $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
        return $this->ok('User updated successfully');
    }

    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return $this->ok('User deleted successfully');
    }
}