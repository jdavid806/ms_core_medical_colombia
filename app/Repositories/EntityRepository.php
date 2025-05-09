<?php

namespace App\Repositories;

use App\Models\Entity;

class EntityRepository extends BaseRepository
{
    const RELATIONS = ['socialSecurities'];

    public function __construct(Entity $entity)
    {
        parent::__construct($entity, self::RELATIONS);
    }
}
