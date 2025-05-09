<?php

namespace App\Services\Api\V1;

use App\Models\Agent;
use App\Exceptions\AgentException;
use App\Repositories\AgentRepository;
use Illuminate\Http\Response;

class AgentService
{
    public function __construct(private AgentRepository $agentRepository) {}

    public function getAllAgents($filters, $perPage)
    {
        try {
            return Agent::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new AgentException('Failed to retrieve Agents', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAgentById(Agent $agent)
    {
        $result = $this->agentRepository->find($agent);
        if (!$result) {
            throw new AgentException('Agent not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createAgent(array $data)
    {
        try {
            return $this->agentRepository->create($data);
        } catch (\Exception $e) {
            throw new AgentException('Failed to create Agent', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAgent(Agent $agent, array $data)
    {
        try {
            return $this->agentRepository->update($agent, $data);
        } catch (\Exception $e) {
            throw new AgentException('Failed to update Agent', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAgent(Agent $agent)
    {
        try {
            return $this->agentRepository->delete($agent);
        } catch (\Exception $e) {
            throw new AgentException('Failed to delete Agent', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}