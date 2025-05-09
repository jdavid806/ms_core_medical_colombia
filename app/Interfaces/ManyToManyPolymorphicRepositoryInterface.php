<?php

namespace App\Interfaces;

interface ManyToManyPolymorphicRepositoryInterface
{
    public function ofParent($parentId);
    public function ofParentByChildType($parentId, string $childType);
    public function createForParent($parentId, array $children);
    public function updateForParent($parentId, array $children);
    public function deleteForParent($parentId, array $children);
}
