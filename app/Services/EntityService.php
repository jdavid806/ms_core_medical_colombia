<?php

namespace App\Services;

use App\Models\Entity;
use App\Repositories\EntityRepository;


class EntityService
{
    public function __construct(private EntityRepository $entityRepository) {}

    public function getAllEntitys()
    {
        return $this->entityRepository->all();
    }

    public function getEntityById($entity)
    {
        return $this->entityRepository->find($entity);
    }

    public function createEntity(array $data)
    {
        return $this->entityRepository->create($data);
    }

    public function updateEntity(Entity $entity, array $data)
    {

        return $this->entityRepository->update($entity->id, $data);
    }

    public function deleteEntity(Entity $entity)
    {
        return $this->entityRepository->delete($entity->id);
    }
}
