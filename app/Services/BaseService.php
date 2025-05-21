<?php

namespace App\Services;

use App\Helpers\ExceptionHandlerHelper;
use App\Interfaces\BaseRepositoryInterface;
use App\Interfaces\BaseServiceInterface;
use Exception;

class BaseService implements BaseServiceInterface
{
    protected $repository;
    protected array $customExceptionMessages = [];

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        try {
            return $this->repository->all();
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function getById($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function getByColumn($column, $value)
    {
        try {
            return $this->repository->findByColumn($column, $value);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function update($id, array $data)
    {

        try {
            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function updateOrCreate(array $data)
    {
        try {
            return $this->repository->updateOrCreate($data);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function delete($id)
    {
        try {
            return $this->repository->update($id, ['is_active' => false]);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function active()
    {
        try {
            return $this->repository->active();
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }

    public function activeCount()
    {
        try {
            return $this->repository->activeCount();
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }
}
