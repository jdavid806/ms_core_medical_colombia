<?php

namespace App\Repositories;

use App\Interfaces\ManyToManyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ManyToManyRepository extends BaseRepository implements ManyToManyRepositoryInterface
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation;

    public function __construct(Model $model, Model $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function ofParent($parentId)
    {
        return $this->findParent($parentId)->{$this->childrenRelation};
    }

    public function createForParent($parentId, array $childrenIds)
    {
        return $this->findParent($parentId)
            ->{$this->childrenRelation}()
            ->syncWithoutDetaching($childrenIds);
    }

    public function updateForParent($parentId, array $childrenIds)
    {
        return $this->findParent($parentId)
            ->{$this->childrenRelation}()
            ->sync($childrenIds);
    }

    public function deleteForParent($parentId, array $childrenIds)
    {
        return $this->findParent($parentId)
            ->{$this->childrenRelation}()
            ->detach($childrenIds);
    }

    protected function findParent($parentId): Model
    {
        return $this->parentModel->findOrFail($parentId);
    }
}
