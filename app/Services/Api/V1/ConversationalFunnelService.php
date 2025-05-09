<?php

namespace App\Services\Api\V1;

use App\Models\ConversationalFunnel;
use App\Exceptions\ConversationalFunnelException;
use App\Repositories\ConversationalFunnelRepository;
use Illuminate\Http\Response;

class ConversationalFunnelService
{
    public function __construct(private ConversationalFunnelRepository $conversationalFunnelRepository) {}

    public function getAllConversationalFunnels($filters, $perPage)
    {
        try {
            return ConversationalFunnel::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new ConversationalFunnelException('Failed to retrieve ConversationalFunnels', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getConversationalFunnelById(ConversationalFunnel $conversationalFunnel)
    {
        $result = $this->conversationalFunnelRepository->find($conversationalFunnel);
        if (!$result) {
            throw new ConversationalFunnelException('ConversationalFunnel not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createConversationalFunnel(array $data)
    {
        try {
            return $this->conversationalFunnelRepository->create($data);
        } catch (\Exception $e) {
            throw new ConversationalFunnelException('Failed to create ConversationalFunnel', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateConversationalFunnel(ConversationalFunnel $conversationalFunnel, array $data)
    {
        try {
            return $this->conversationalFunnelRepository->updateModel($conversationalFunnel, $data);
        } catch (\Exception $e) {
            throw new ConversationalFunnelException('Failed to update ConversationalFunnel', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteConversationalFunnel(ConversationalFunnel $conversationalFunnel)
    {
        try {
            return $this->conversationalFunnelRepository->deleteModel($conversationalFunnel);
        } catch (\Exception $e) {
            throw new ConversationalFunnelException('Failed to delete ConversationalFunnel', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}