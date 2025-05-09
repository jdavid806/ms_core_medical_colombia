<?php

namespace App\Repositories;

use App\Interfaces\ManyToManyPolymorphicRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ManyToManyPolymorphicRepository extends BaseRepository implements ManyToManyPolymorphicRepositoryInterface
{
    protected $model;
    protected $parentModel;
    protected array $childTypeRelation = [];

    public function __construct(Model $model, Model $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function ofParent($parentId)
    {
        $parent = $this->parentModel->with(array_values($this->childTypeRelation))->findOrFail($parentId);

        $allChildren = collect();

        foreach ($this->childTypeRelation as $relation) {
            $allChildren = $allChildren->merge($parent->{$relation});
        }

        return $allChildren;
    }

    public function ofParentByChildType($parentId, string $childType)
    {
        $relation = $this->getChildRelation($childType);

        return $this->findParent($parentId)->{$relation};
    }

    public function createForParent($parentId, array $children)
    {
        $this->processChildren($parentId, $children, 'syncWithoutDetaching');
    }

    public function updateForParent($parentId, array $children)
    {
        $this->processChildren($parentId, $children, 'sync');
    }

    public function deleteForParent($parentId, array $children)
    {
        $this->processChildren($parentId, $children, 'detach');
    }

    protected function processChildren($parentId, array $children, string $action)
    {
        $parent = $this->findParent($parentId);

        $groupedChildren = collect($children)->groupBy('type');

        foreach ($groupedChildren as $childType => $items) {
            $childrenIds = Arr::pluck($items, 'id');
            $relation = $this->getChildRelation($childType);

            $parent->{$relation}()->{$action}($childrenIds);
        }
    }

    protected function getChildRelation(string $childType): string
    {
        if (!isset($this->childTypeRelation[$childType])) {
            throw new \InvalidArgumentException("Tipo de hijo no válido: {$childType}");
        }

        return $this->childTypeRelation[$childType];
    }

    protected function findParent($parentId): Model
    {
        return $this->parentModel->findOrFail($parentId);
    }
}
