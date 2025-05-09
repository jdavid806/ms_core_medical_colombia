<?php

namespace App\Repositories;

use App\Interfaces\OneToManyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OneToManyRepository extends BaseRepository implements OneToManyRepositoryInterface
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
        return $this->parentModel
            ->findOrFail($parentId)
            ->{$this->childrenRelation}()
            ->where('is_active', 1)
            ->get();
    }

    public function createForParent($parentId, array $data)
    {
        return $this->parentModel
            ->findOrFail($parentId)
            ->{$this->childrenRelation}()
            ->create($data);
    }

    public function createManyForParent($parentId, array $dataArray)
    {
        return $this->parentModel
            ->findOrFail($parentId)
            ->{$this->childrenRelation}()
            ->createMany($dataArray);
    }

    public function syncManyForParent($parentId, array $data)
    {
        $this->parentModel
            ->findOrFail($parentId)
            ->{$this->childrenRelation}()
            ->delete();

        return $this->createManyForParent($parentId, $data);
    }
}
