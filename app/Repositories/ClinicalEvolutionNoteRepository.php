<?php

namespace App\Repositories;

use App\Models\ClinicalEvolutionNote;
use App\Models\ClinicalRecord;

class ClinicalEvolutionNoteRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'evolutionNotes';

    public function __construct(ClinicalEvolutionNote $model, ClinicalRecord $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function getEvolutionByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->model->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])
            ->where('create_by_user_id', $userId)->whereHas('clinicalRecord', function ($query) use ($patientId) {
                $query->where("patient_id", $patientId);
            })
            ->get();
    }
}
