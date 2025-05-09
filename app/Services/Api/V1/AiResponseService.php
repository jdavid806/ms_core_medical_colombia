<?php

namespace App\Services\Api\V1;

use App\Models\AiResponse;
use App\Exceptions\AiResponseException;
use App\Models\Agent;
use App\Repositories\AiResponseRepository;
use Illuminate\Http\Response;

class AiResponseService
{
    public function __construct(private AiResponseRepository $aiResponseRepository) {}

    public function getAllAiResponses($filters, $perPage)
    {

        try {

            return AiResponse::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new AiResponseException('Failed to retrieve AiResponses', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAiResponseById(AiResponse $aiResponse)
    {
        $result = $this->aiResponseRepository->find($aiResponse);
        if (!$result) {
            throw new AiResponseException('AiResponse not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createAiResponse(array $data)
    {
        try {
            $responsableClass = $this->resolveResponsableClass($data['responsable_type']);

    
            $responsable = $responsableClass::find($data['responsable_id']);

            if (!$responsable) {
                throw new AiResponseException('Responsable no encontrado', Response::HTTP_NOT_FOUND);
            }
    
            // Validar existencia del agente en la tabla `agents`
            $agent = Agent::findOrFail($data['agent_id']); // Usar la columna correcta: agent_id
    
            $payload = [
                'responsable_type' => $responsableClass,
                'responsable_id' => $data['responsable_id'],
                'agent_id' => $agent->id, // Id del agente desde la tabla `agents`
                'response' => ['mensaje' => $data['mensaje']],
                'status' => 'success',
            ];

    
            return $this->aiResponseRepository->create($payload);
    
        } catch (\Exception $e) {
            throw new AiResponseException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    protected function resolveResponsableClass(string $type): string
    {
        $map = config('ai.responsable_types');


        $type = strtolower($type);

        if (!array_key_exists($type, $map)) {
            throw new AiResponseException("Tipo de responsable '{$type}' no soportado", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $map[$type];
    }


    public function updateAiResponse(AiResponse $aiResponse, array $data)
    {
        try {
            return $this->aiResponseRepository->update($aiResponse, $data);
        } catch (\Exception $e) {
            throw new AiResponseException('Failed to update AiResponse', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAiResponse(AiResponse $aiResponse)
    {
        try {
            return $this->aiResponseRepository->delete($aiResponse);
        } catch (\Exception $e) {
            throw new AiResponseException('Failed to delete AiResponse', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
