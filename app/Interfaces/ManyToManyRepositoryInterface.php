<?php

namespace App\Interfaces;

interface ManyToManyRepositoryInterface extends BaseRepositoryInterface
{
    public function ofParent($parentId);
    public function createForParent($parentId, array $childrenIds);
    public function updateForParent($parentId, array $childrenIds);
    public function deleteForParent($parentId, array $childrenIds);
}
