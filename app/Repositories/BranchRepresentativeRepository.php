<?php

namespace App\Repositories;

use App\Models\BranchRepresentative;

class BranchRepresentativeRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(BranchRepresentative $branchRepresentative)
    {
        parent::__construct($branchRepresentative, self::RELATIONS);
    }
}
