<?php

namespace App\Services;

use App\Helpers\ExceptionHandlerHelper;
use App\Interfaces\OneToManyRepositoryInterface;
use App\Interfaces\OneToManyServiceInterface;
use Exception;

class OneToManyService extends BaseService implements OneToManyServiceInterface
{
    protected $repository;

    public function __construct(OneToManyRepositoryInterface $repository)
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

    public function createForParent($parentId, array $data)
    {
        try {
            return $this->repository->createForParent($parentId, $data);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function createManyForParent($parentId, array $dataArray)
    {

        try {
            return $this->repository->createManyForParent($parentId, $dataArray);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function syncManyForParent($parentId, array $dataArray)
    {
        try {
            return $this->repository->syncManyForParent($parentId, $dataArray);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }
}
