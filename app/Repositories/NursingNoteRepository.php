<?php

namespace App\Repositories;

use App\Models\NursingNote;
use App\Models\Patient;

class NursingNoteRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'nursingNotes';

    public function __construct(NursingNote $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
