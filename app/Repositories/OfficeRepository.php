<?php

namespace App\Repositories;

use App\Models\Office;

class OfficeRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Office $office)
    {
        parent::__construct($office, self::RELATIONS);
    }
}
