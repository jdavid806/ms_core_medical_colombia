<?php

namespace App\Repositories;

use App\Models\IntegrationUser;

class IntegrationUserRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(IntegrationUser $integrationUser)
    {
        parent::__construct($integrationUser, self::RELATIONS);
    }
}
