<?php

namespace App\Repositories;

use App\Models\BranchCompany;

class BranchCompanyRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(BranchCompany $branchCompany)
    {
        parent::__construct($branchCompany, self::RELATIONS);
    }
}
