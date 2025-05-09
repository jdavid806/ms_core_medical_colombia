<?php

namespace App\Repositories;

use App\Models\Billing;

class BillingRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Billing $billing)
    {
        parent::__construct($billing, self::RELATIONS);
    }
}
