<?php

namespace App\Interfaces;

interface ManyToManyServiceInterface extends BaseServiceInterface
{
    public function ofParent($parentId);
    public function createForParent($parentId, array $childrenIds);
    public function updateForParent($parentId, array $childrenIds);
    public function deleteForParent($parentId, array $childrenIds);
}
