<?php

namespace App\Http\Controllers;

use App\Services\ExamPackageItemService;

class ExamPackageItemController extends ManyToManyPolymorphicController
{
    protected $service;

    public function __construct(ExamPackageItemService $service)
    {
        $this->service = $service;
    }
}
