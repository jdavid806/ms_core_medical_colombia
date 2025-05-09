<?php

namespace App\Services;

use App\Models\ExamOrderState;
use App\Repositories\ExamResultRepository;
use Illuminate\Support\Facades\DB;

class ExamResultService extends BaseService
{
    protected $repository;

    public function __construct(ExamResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $examResult = parent::create($data);

            $examOrder = $examResult->examOrder;
            $examOrder->exam_order_state_id = ExamOrderState::where('name', 'uploaded')->first()->id;
            $examOrder->save();

            return $examResult;
        });
    }
}
