<?php

namespace App\Services;

use App\Exceptions\JsonResponseException;
use App\Models\ExamOrderState;
use App\Repositories\ExamOrderRepository;

class ExamOrderService extends BaseService
{
    protected $repository;
    protected $examCategoryService;
    protected $examPackageItemService;

    public function __construct(
        ExamOrderRepository $repository,
        ExamCategoryService $examCategoryService,
        ExamPackageItemService $examPackageItemService
    ) {
        $this->repository = $repository;
        $this->examCategoryService = $examCategoryService;
        $this->examPackageItemService = $examPackageItemService;
    }

    public function create(array $data)
    {
        $orderItemId = $data['exam_order_item_id'];

        switch ($data['exam_order_item_type']) {
            case 'exam_type':
                $this->createForExamType($data, $orderItemId);
                break;
            case 'exam_category':
                $this->createFromExamCategory($data, $orderItemId);
                break;
            case 'exam_package':
                $examItems = $this->examPackageItemService->ofParent($data['exam_order_item_id']);
                foreach ($examItems as $examItem) {
                    switch ($examItem->pivot->exam_package_item_type) {
                        case 'exam_type':
                            $this->createForExamType($data, $examItem->id);
                            break;
                        case 'exam_category':
                            $this->createFromExamCategory($data, $examItem->id);
                            break;
                        default:
                            throw new JsonResponseException('Tipo de item de paquete de examen no manejado: ' . $examItem->pivot->exam_package_item_type);
                    }
                }
                break;
            default:
                throw new JsonResponseException('Tipo de item de orden de examen no manejado: ' . $data['exam_order_item_type']);
        }
    }

    protected function createForExamType(array $data, $examTypeId)
    {
        $this->repository->create(array_merge($data, [
            'exam_type_id' => $examTypeId,
            'exam_order_state_id' => ExamOrderState::where('name', 'generated')->first()->id
        ]));
    }

    protected function createFromExamCategory(array $data, $categoryId)
    {
        $examTypes = $this->examCategoryService->getExamTypes($categoryId);
        foreach ($examTypes as $examType) {
            $this->createForExamType($data, $examType->id);
        }
    }

    public function getLastbyPatient($patientId)
    {
        return $this->repository->getLastbyPatient($patientId);
    }
}
