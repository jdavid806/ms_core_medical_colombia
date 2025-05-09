<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    const RELATIONS = ['representatives', 'offices', 'billings', 'contacts', 'communication'];

    public function __construct(Company $company)
    {
        parent::__construct($company, self::RELATIONS);
    }
}
