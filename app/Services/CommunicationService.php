<?php

namespace App\Services;

use App\Models\Communication;
use App\Repositories\CommunicationRepository;

class CommunicationService
{
    public function __construct(private CommunicationRepository $communicationRepository) {}

    public function getAllCommunications()
    {
        return $this->communicationRepository->all();
    }

    public function getCommunicationById(Communication $communication)
    {
        return $this->communicationRepository->find($communication);
    }

    public function createCommunication(array $data)
    {
        return $this->communicationRepository->create($data);
    }

    public function updateCommunication(Communication $communication, array $data)
    {
        return $this->communicationRepository->update($communication, $data);
    }

    public function deleteCommunication(Communication $communication)
    {
        return $this->communicationRepository->delete($communication);
    }
}
