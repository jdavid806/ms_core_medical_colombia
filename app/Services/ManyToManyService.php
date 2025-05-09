<?php

namespace App\Services;

use App\Helpers\ExceptionHandlerHelper;
use App\Interfaces\ManyToManyRepositoryInterface;
use App\Interfaces\ManyToManyServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ManyToManyService extends BaseService implements ManyToManyServiceInterface
{
    protected $repository;

    public function __construct(ManyToManyRepositoryInterface $repository)
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

    public function createForParent($parentId, array $childrenIds)
    {
        try {
            return DB::transaction(function () use ($parentId, $childrenIds) {
                return $this->repository->createForParent($parentId, $childrenIds);
            });
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function updateForParent($parentId, array $childrenIds)
    {
        try {
            return DB::transaction(function () use ($parentId, $childrenIds) {
                return $this->repository->updateForParent($parentId, $childrenIds);
            });
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function deleteForParent($parentId, array $childrenIds)
    {
        try {
            return $this->repository->deleteForParent($parentId, $childrenIds);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }
}
