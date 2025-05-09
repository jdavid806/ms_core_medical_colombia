<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\MedicalHistorySummary;
use App\Filters\MedicalHistorySummaryFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\MedicalHistorySummaryService;
use App\Http\Resources\Api\V1\MedicalHistorySummary\MedicalHistorySummaryResource;
use App\Http\Requests\Api\V1\MedicalHistorySummary\StoreMedicalHistorySummaryRequest;
use App\Http\Requests\Api\V1\MedicalHistorySummary\UpdateMedicalHistorySummaryRequest;

class MedicalHistorySummaryController extends ApiController
{
    public function __construct(private MedicalHistorySummaryService $medicalHistorySummaryService) {}

    public function index(MedicalHistorySummaryFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $medicalHistorySummarys = $this->medicalHistorySummaryService->getAllMedicalHistorySummarys($filters, $perPage);

        return $this->ok('MedicalHistorySummarys retrieved successfully', MedicalHistorySummaryResource::collection($medicalHistorySummarys));
    }

    public function store(StoreMedicalHistorySummaryRequest $request)
    {
        $medicalHistorySummary = $this->medicalHistorySummaryService->createMedicalHistorySummary($request->validated());
        return $this->ok('MedicalHistorySummary created successfully', new MedicalHistorySummaryResource($medicalHistorySummary));
    }

    public function show(MedicalHistorySummary $medicalHistorySummary)
    {
        return $this->ok('MedicalHistorySummary retrieved successfully', new MedicalHistorySummaryResource($medicalHistorySummary));
    }

    public function update(UpdateMedicalHistorySummaryRequest $request, MedicalHistorySummary $medicalHistorySummary)
    {
        $this->medicalHistorySummaryService->updateMedicalHistorySummary($medicalHistorySummary, $request->validated());
        return $this->ok('MedicalHistorySummary updated successfully');
    }

    public function destroy(MedicalHistorySummary $medicalHistorySummary)
    {
        $this->medicalHistorySummaryService->deleteMedicalHistorySummary($medicalHistorySummary);
        return $this->ok('MedicalHistorySummary deleted successfully');
    }
}