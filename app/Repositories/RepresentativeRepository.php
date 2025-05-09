<?php

namespace App\Repositories;

use App\Models\Representative;

class RepresentativeRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Representative $representative)
    {
        parent::__construct($representative, self::RELATIONS);
    }
}
