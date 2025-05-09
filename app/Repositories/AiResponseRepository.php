<?php

namespace App\Repositories;

use App\Models\AiResponse;

class AiResponseRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(AiResponse $aiResponse)
    {
        parent::__construct($aiResponse, self::RELATIONS);
    }
}
