<?php

namespace App\Repositories;

use App\Models\ExternalProductCache;

class ExternalProductCacheRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(ExternalProductCache $externalProductCache)
    {
        parent::__construct($externalProductCache, self::RELATIONS);
    }
}
