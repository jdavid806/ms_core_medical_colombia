<?php

namespace App\Repositories;

use App\Models\IntegrationCredential;

class IntegrationCredentialRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(IntegrationCredential $integrationCredential)
    {
        parent::__construct($integrationCredential, self::RELATIONS);
    }
}
