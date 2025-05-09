<?php

namespace App\Services;

use App\Helpers\ExceptionHandlerHelper;
use App\Interfaces\ManyToManyPolymorphicRepositoryInterface;
use App\Interfaces\ManyToManyPolymorphicServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ManyToManyPolymorphicService extends BaseService implements ManyToManyPolymorphicServiceInterface
{
    protected $repository;

    public function __construct(ManyToManyPolymorphicRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function ofParent($parentId)
    {
        try {
            return $this->repository->ofParent($parentId);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function ofParentByChildType($parentId, string $childType)
    {
        try {
            return $this->repository->ofParentByChildType($parentId, $childType);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function createForParent($parentId, array $children)
    {
        try {
            return DB::transaction(function () use ($parentId, $children) {
                return $this->repository->createForParent($parentId, $children);
            });
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function updateForParent($parentId, array $children)
    {
        try {
            return DB::transaction(function () use ($parentId, $children) {
                return $this->repository->updateForParent($parentId, $children);
            });
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function deleteForParent($parentId, array $children)
    {
        try {
            return $this->repository->deleteForParent($parentId, $children);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }
}
