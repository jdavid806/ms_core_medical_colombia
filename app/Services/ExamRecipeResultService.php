<?php

namespace App\Services;

use App\Helpers\ExceptionHandlerHelper;
use App\Repositories\ExamRecipeResultRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

class ExamRecipeResultService extends BaseService
{
    protected $repository;

    public function __construct(ExamRecipeResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $examRecipeResult = parent::create($data);

            $examRecipe = $examRecipeResult->examRecipe;
            $examRecipe->status = 'uploaded';
            $examRecipe->save();

            return $examRecipeResult;
        });
    }

    public function delete($id)
    {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e, $this->customExceptionMessages);
        }
    }
}
