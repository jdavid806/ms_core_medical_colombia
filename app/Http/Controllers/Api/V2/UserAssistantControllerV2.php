<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\User;
use App\Models\UserAssistant;
use App\Filters\UserAssistantFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V2\UserAssistant\BulkStoreUserAssistantRequestV2;
use App\Services\Api\V2\UserAssistantServiceV2;
use App\Http\Resources\Api\V2\UserAssistant\UserAssistantResourceV2;
use App\Http\Requests\Api\V2\UserAssistant\StoreUserAssistantRequestV2;
use App\Http\Requests\Api\V2\UserAssistant\UpdateUserAssistantRequestV2;
use App\Http\Resources\Api\V2\User\UserResourceV2;

class UserAssistantControllerV2 extends ApiController
{
    public function __construct(private UserAssistantServiceV2 $userAssistantService) {}

    public function index(UserAssistantFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $userAssistants = $this->userAssistantService->getAllUserAssistants($filters, $perPage);

        return $this->ok('UserAssistants retrieved successfully', UserAssistantResourceV2::collection($userAssistants));
    }

    public function store(StoreUserAssistantRequestV2 $request)
    {
        $userAssistant = $this->userAssistantService->createUserAssistant($request->validated());
        return $this->ok('UserAssistant created successfully', new UserAssistantResourceV2($userAssistant));
    }

    public function bulkStore(BulkStoreUserAssistantRequestV2 $request)
    {
        $data = $request->validated();
        $userAssistants = $this->userAssistantService->bulkCreateUserAssistants($data['supervisor_user_id'], $data['assistants']);
        return $this->ok('UserAssistants created successfully', UserResourceV2::collection($userAssistants));
    }

    public function show(UserAssistant $userAssistant)
    {
        return $this->ok('UserAssistant retrieved successfully', new UserAssistantResourceV2($userAssistant));
    }

    public function update(UpdateUserAssistantRequestV2 $request, UserAssistant $userAssistant)
    {
        $this->userAssistantService->updateUserAssistant($userAssistant, $request->validated());
        return $this->ok('UserAssistant updated successfully');
    }

    public function destroy(UserAssistant $userAssistant)
    {
        $this->userAssistantService->deleteUserAssistant($userAssistant);

        return $this->ok('UserAssistant deleted successfully');
    }

    public function getAssistantsByUser(User $user)
    {
        $assistants = $this->userAssistantService->getAssistantsByUser($user);

        return $this->ok('Assistants retrieved successfully', UserResourceV2::collection($assistants));
    }
}
