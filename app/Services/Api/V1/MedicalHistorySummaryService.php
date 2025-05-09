<?php

namespace App\Services\Api\V1;

use App\Models\MedicalHistorySummary;
use App\Exceptions\MedicalHistorySummaryException;
use App\Repositories\MedicalHistorySummaryRepository;
use Illuminate\Http\Response;

class MedicalHistorySummaryService
{
    public function __construct(private MedicalHistorySummaryRepository $medicalHistorySummaryRepository) {}

    public function getAllMedicalHistorySummarys($filters, $perPage)
    {
        try {
            return MedicalHistorySummary::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new MedicalHistorySummaryException('Failed to retrieve MedicalHistorySummarys', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMedicalHistorySummaryById(MedicalHistorySummary $medicalHistorySummary)
    {
        $result = $this->medicalHistorySummaryRepository->find($medicalHistorySummary);
        if (!$result) {
            throw new MedicalHistorySummaryException('MedicalHistorySummary not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createMedicalHistorySummary(array $data)
    {
        try {
            return $this->medicalHistorySummaryRepository->create($data);
        } catch (\Exception $e) {
            throw new MedicalHistorySummaryException('Failed to create MedicalHistorySummary', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMedicalHistorySummary(MedicalHistorySummary $medicalHistorySummary, array $data)
    {
        try {
            return $this->medicalHistorySummaryRepository->update($medicalHistorySummary, $data);
        } catch (\Exception $e) {
            throw new MedicalHistorySummaryException('Failed to update MedicalHistorySummary', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteMedicalHistorySummary(MedicalHistorySummary $medicalHistorySummary)
    {
        try {
            return $this->medicalHistorySummaryRepository->delete($medicalHistorySummary);
        } catch (\Exception $e) {
            throw new MedicalHistorySummaryException('Failed to delete MedicalHistorySummary', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}