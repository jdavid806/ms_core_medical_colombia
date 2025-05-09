<?php

namespace App\Repositories;

use App\Models\Agent;

class AgentRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Agent $agent)
    {
        parent::__construct($agent, self::RELATIONS);
    }
}
