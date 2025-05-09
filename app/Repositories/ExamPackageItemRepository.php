<?php

namespace App\Repositories;

use App\Models\ExamPackage;
use App\Models\ExamPackageItem;

class ExamPackageItemRepository extends ManyToManyPolymorphicRepository
{
    protected $model;
    protected $parentModel;
    protected array $childTypeRelation = [
        "exam_type" => "examTypes",
        "exam_category" => "examCategories"
    ];

    public function __construct(ExamPackageItem $model, ExamPackage $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
