<?php

namespace App\Services;

use App\Exceptions\UserScheduleUnavailableException;
use App\Models\UserAvailability;
use App\Repositories\UserAvailabilityRepository;

class UserAvailabilityService extends OneToManyService
{
    protected $repository;
    protected $userAvailabilityFreeSlotService;

    public function __construct(
        UserAvailabilityRepository $repository,
        UserAvailabilityFreeSlotService $userAvailabilityFreeSlotsService
    ) {
        $this->repository = $repository;
        $this->userAvailabilityFreeSlotService = $userAvailabilityFreeSlotsService;
    }

    public function createForParent($parentId, array $data)
    {
        $userAvailability = parent::createForParent($parentId, $data);
        $this->storeFreeSlots($userAvailability->id, $data);
        $userAvailability->load('freeSlots');

        return $userAvailability;
    }

    public function update($id, array $data)
    {
        $userAvailability = parent::update($id, $data);
        $this->storeFreeSlots($userAvailability->id, $data);
        $userAvailability->load('freeSlots');

        return $userAvailability;
    }

    public function storeFreeSlots($id, array $data)
    {
        if (!isset($data['free_slots'])) return;

        $this->userAvailabilityFreeSlotService->syncManyForParent(
            $id,
            $data['free_slots']
        );
    }

    public function getDateAvailabilities($data)
    {
        return UserAvailability::query()->get();
    }

    public function getAvailableSlots($data)
    {
        return $this->repository->getAvailableSlots($data);
    }
}
