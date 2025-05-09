<?php

namespace App\Repositories;

use App\Models\Integration;

class IntegrationRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Integration $integration)
    {
        parent::__construct($integration, self::RELATIONS);
    }
}
