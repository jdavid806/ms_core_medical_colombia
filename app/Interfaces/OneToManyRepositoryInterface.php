<?php

namespace App\Interfaces;

interface OneToManyRepositoryInterface extends BaseRepositoryInterface
{
    public function ofParent($parentId);
    public function createForParent($parentId, array $data);
    public function createManyForParent($parentId, array $dataArray);
    public function syncManyForParent($parentId, array $dataArray);
}
