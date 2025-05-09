<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ConversationalFunnel;
use App\Filters\ConversationalFunnelFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\ConversationalFunnelService;
use App\Http\Resources\Api\V1\ConversationalFunnel\ConversationalFunnelResource;
use App\Http\Requests\Api\V1\ConversationalFunnel\StoreConversationalFunnelRequest;
use App\Http\Requests\Api\V1\ConversationalFunnel\UpdateConversationalFunnelRequest;

class ConversationalFunnelController extends ApiController
{
    public function __construct(private ConversationalFunnelService $conversationalFunnelService) {}

    public function index(ConversationalFunnelFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $conversationalFunnels = $this->conversationalFunnelService->getAllConversationalFunnels($filters, $perPage);

        return $this->ok('ConversationalFunnels retrieved successfully', ConversationalFunnelResource::collection($conversationalFunnels));
    }

    public function store(StoreConversationalFunnelRequest $request)
    {
        $conversationalFunnel = $this->conversationalFunnelService->createConversationalFunnel($request->validated());
        return $this->ok('ConversationalFunnel created successfully', new ConversationalFunnelResource($conversationalFunnel));
    }

    public function show(ConversationalFunnel $conversationalFunnel)
    {
        return $this->ok('ConversationalFunnel retrieved successfully', new ConversationalFunnelResource($conversationalFunnel));
    }

    public function update(UpdateConversationalFunnelRequest $request, ConversationalFunnel $conversational_funnel)
    {

        $this->conversationalFunnelService->updateConversationalFunnel($conversational_funnel, $request->validated());
        return $this->ok('ConversationalFunnel updated successfully');
    }

    public function destroy(ConversationalFunnel $conversationalFunnel)
    {
        $this->conversationalFunnelService->deleteConversationalFunnel($conversationalFunnel);
        return $this->ok('ConversationalFunnel deleted successfully');
    }
}