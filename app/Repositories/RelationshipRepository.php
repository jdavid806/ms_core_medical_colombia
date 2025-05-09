<?php

namespace App\Repositories;

use App\Models\Relationship;

class RelationshipRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Relationship $relationship)
    {
        parent::__construct($relationship, self::RELATIONS);
    }
}
