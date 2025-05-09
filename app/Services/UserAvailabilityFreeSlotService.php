<?php

namespace App\Services;

use App\Repositories\UserAvailabilityFreeSlotRepository;

class UserAvailabilityFreeSlotService extends OneToManyService
{
    protected $repository;

    public function __construct(UserAvailabilityFreeSlotRepository $repository)
    {
        $this->repository = $repository;
    }
}
