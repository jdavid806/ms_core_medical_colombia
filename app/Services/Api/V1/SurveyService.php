<?php

namespace App\Services\Api\V1;

use App\Models\Survey;
use App\Exceptions\SurveyException;
use App\Repositories\SurveyRepository;
use Illuminate\Http\Response;

class SurveyService
{
    public function __construct(private SurveyRepository $surveyRepository) {}

    public function getAllSurveys($filters, $perPage)
    {
        try {
            return Survey::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new SurveyException('Failed to retrieve Surveys', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSurveyById(Survey $survey)
    {
        $result = $this->surveyRepository->find($survey);
        if (!$result) {
            throw new SurveyException('Survey not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createSurvey(array $data)
    {
        try {
            return $this->surveyRepository->create($data);
        } catch (\Exception $e) {
            throw new SurveyException('Failed to create Survey', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateSurvey(Survey $survey, array $data)
    {
        try {
            return $this->surveyRepository->update($survey, $data);
        } catch (\Exception $e) {
            throw new SurveyException('Failed to update Survey', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSurvey(Survey $survey)
    {
        try {
            return $this->surveyRepository->delete($survey);
        } catch (\Exception $e) {
            throw new SurveyException('Failed to delete Survey', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}