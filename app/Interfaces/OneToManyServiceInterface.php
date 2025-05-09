<?php

namespace App\Interfaces;

interface OneToManyServiceInterface extends BaseServiceInterface
{
    public function ofParent($parentId);
    public function createForParent($parentId, array $data);
    public function createManyForParent($parentId, array $dataArray);
}
