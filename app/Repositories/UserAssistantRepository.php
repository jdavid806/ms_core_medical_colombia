<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserAssistant;

class UserAssistantRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(UserAssistant $userAssistant)
    {
        parent::__construct($userAssistant, self::RELATIONS);
    }

    public function bulkCreate($supervisorUserId, array $assistantIds)
    {
        $supervisorUser = User::findOrFail($supervisorUserId);
        $supervisorUser->assistants()->sync($assistantIds);
        return $supervisorUser->assistants()->get();
    }
}
