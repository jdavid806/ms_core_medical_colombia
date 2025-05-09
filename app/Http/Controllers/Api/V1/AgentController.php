<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Filters\AgentFilter;
use App\Services\Api\V1\AgentService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\Agent\AgentResource;
use App\Http\Requests\Api\V1\Agent\StoreAgentRequest;
use App\Http\Requests\Api\V1\Agent\UpdateAgentRequest;

class AgentController extends ApiController
{
    public function __construct(private AgentService $agentService) {}

    public function index(AgentFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $agents = $this->agentService->getAllAgents($filters, $perPage);

        return $this->ok('Agents retrieved successfully', AgentResource::collection($agents));
    }

    public function store(StoreAgentRequest $request)
    {
        $agent = $this->agentService->createAgent($request->validated());
        return $this->ok('Agent created successfully', new AgentResource($agent));
    }

    public function show(Agent $agent)
    {
        if($this->include('aiResponse')) {
            $agent->load('aiResponses');
        }
        return $this->ok('Agent retrieved successfully', new AgentResource($agent));
    }

    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        $this->agentService->updateAgent($agent, $request->validated());
        return $this->ok('Agent updated successfully');
    }

    public function destroy(Agent $agent)
    {
        $this->agentService->deleteAgent($agent);
        return $this->ok('Agent deleted successfully');
    }
}