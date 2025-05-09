<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Survey;
use App\Filters\SurveyFilter;
use App\Services\Api\V1\SurveyService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\Survey\SurveyResource;
use App\Http\Requests\Api\V1\Survey\StoreSurveyRequest;
use App\Http\Requests\Api\V1\Survey\UpdateSurveyRequest;

class SurveyControllerV1 extends ApiController
{
    public function __construct(private SurveyService $surveyService) {}

    public function index(SurveyFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $surveys = $this->surveyService->getAllSurveys($filters, $perPage);

        return $this->ok('Surveys retrieved successfully', SurveyResource::collection($surveys));
    }

    public function store(StoreSurveyRequest $request)
    {
        $survey = $this->surveyService->createSurvey($request->validated());
        return $this->ok('Survey created successfully', new SurveyResource($survey));
    }

    public function show(Survey $survey)
    {
        return $this->ok('Survey retrieved successfully', new SurveyResource($survey));
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $this->surveyService->updateSurvey($survey, $request->validated());
        return $this->ok('Survey updated successfully');
    }

    public function destroy(Survey $survey)
    {
        $this->surveyService->deleteSurvey($survey);
        return $this->ok('Survey deleted successfully');
    }
}