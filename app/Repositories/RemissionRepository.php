<?php

namespace App\Repositories;

use App\Models\ClinicalRecord;
use App\Models\Remission;

class RemissionRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'remissions';

    public function __construct(Remission $model, ClinicalRecord $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function getRemissionByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->model->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])
            ->where('receiver_user_id', $userId)->whereHas('clinicalRecord', function ($query) use ($patientId) {
                $query->where("patient_id", $patientId);
            })
            ->get();
    }
}
