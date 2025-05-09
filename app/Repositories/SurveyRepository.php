<?php

namespace App\Repositories;

use App\Models\Survey;

class SurveyRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Survey $survey)
    {
        parent::__construct($survey, self::RELATIONS);
    }
}
