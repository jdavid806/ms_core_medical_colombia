<?php

namespace App\Repositories;

use App\Models\Companion;


class CompanionRepository extends BaseRepository
{
    CONST RELATIONS = ['patients'];
    public function __construct(Companion $companion)
    {
        parent::__construct($companion, self::RELATIONS);
    }

}


