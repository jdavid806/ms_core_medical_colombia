<?php

namespace App\Repositories;

use App\Models\Communication;

class CommunicationRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Communication $communication)
    {
        parent::__construct($communication, self::RELATIONS);
    }
}
