<?php

namespace App\Services\Api\V1;

use App\Models\Disability;
use Illuminate\Http\Response;
use App\Models\PatientDisability;
use App\Exceptions\DisabilityException;
use App\Repositories\DisabilityRepository;

class DisabilityService
{
    public function __construct(private DisabilityRepository $disabilityRepository) {}

    public function getAllDisabilitys($filters, $perPage)
    {
        try {
            return PatientDisability::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new DisabilityException('Failed to retrieve Disabilitys', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDisabilityById(PatientDisability $disability)
    {
        $result = $this->disabilityRepository->find($disability);
        if (!$result) {
            throw new DisabilityException('Disability not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createDisability(array $data)
    {
        try {
            return $this->disabilityRepository->create($data);
        } catch (\Exception $e) {
            throw new DisabilityException('Failed to create Disability', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateDisability(PatientDisability $disability, array $data)
    {
        try {
            return $this->disabilityRepository->update($disability, $data);
        } catch (\Exception $e) {
            throw new DisabilityException('Failed to update Disability', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteDisability(PatientDisability $disability)
    {
        try {
            return $this->disabilityRepository->delete($disability);
        } catch (\Exception $e) {
            throw new DisabilityException('Failed to delete Disability', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}