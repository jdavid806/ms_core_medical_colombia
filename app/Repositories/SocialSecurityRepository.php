<?php

namespace App\Repositories;

use App\Models\SocialSecurity;

class SocialSecurityRepository extends BaseRepository
{
    const RELATIONS = ['patients', 'entity'];

    public function __construct(SocialSecurity $socialSecurity)
    {
        parent::__construct($socialSecurity, self::RELATIONS);
    }
}
