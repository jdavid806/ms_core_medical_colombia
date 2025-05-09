<?php

namespace App\Services;

use App\Models\Relationship;
use App\Repositories\RelationshipRepository;

class RelationshipService
{
    public function __construct(private RelationshipRepository $relationshipRepository) {}

    public function getAllRelationships()
    {
        return $this->relationshipRepository->all();
    }

    public function getRelationshipById(Relationship $relationship)
    {
        return $this->relationshipRepository->find($relationship);
    }

    public function createRelationship(array $data)
    {
        return $this->relationshipRepository->create($data);
    }

    public function updateRelationship(Relationship $relationship, array $data)
    {
        return $this->relationshipRepository->update($relationship, $data);
    }

    public function deleteRelationship(Relationship $relationship)
    {
        return $this->relationshipRepository->delete($relationship);
    }
}
