<?php

namespace App\Repositories;

use App\Models\UserAvailability;
use App\Models\UserAvailabilityFreeSlot;

class UserAvailabilityFreeSlotRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'freeSlots';

    public function __construct(UserAvailabilityFreeSlot $model, UserAvailability $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
