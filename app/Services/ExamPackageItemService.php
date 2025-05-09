<?php

namespace App\Services;

use App\Repositories\ExamPackageItemRepository;

class ExamPackageItemService extends ManyToManyPolymorphicService
{
    protected $repository;

    public function __construct(ExamPackageItemRepository $repository)
    {
        $this->repository = $repository;
    }
}
