<?php

namespace App\Services;

use App\Repositories\ClinicalRecordTypeRepository;

class ClinicalRecordTypeService extends BaseService
{
    protected $repository;

    public function __construct(ClinicalRecordTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
