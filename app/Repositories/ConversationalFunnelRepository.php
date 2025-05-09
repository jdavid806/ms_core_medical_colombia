<?php

namespace App\Repositories;

use App\Models\ConversationalFunnel;

class ConversationalFunnelRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(ConversationalFunnel $conversationalFunnel)
    {
        parent::__construct($conversationalFunnel, self::RELATIONS);
    }
}
