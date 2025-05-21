<?php

namespace App\Services\Api\V1;

use App\Models\ExternalProductCache;
use App\Exceptions\ExternalProductCacheException;
use App\Repositories\ExternalProductCacheRepository;
use Illuminate\Http\Response;

class ExternalProductCacheService
{
    public function __construct(private ExternalProductCacheRepository $externalProductCacheRepository) {}

    public function getAllExternalProductCaches($filters, $perPage)
    {
        try {
            return ExternalProductCache::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new ExternalProductCacheException('Failed to retrieve ExternalProductCaches', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getExternalProductCacheById(ExternalProductCache $externalProductCache)
    {
        $result = $this->externalProductCacheRepository->find($externalProductCache);
        if (!$result) {
            throw new ExternalProductCacheException('ExternalProductCache not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createExternalProductCache(array $data)
    {
        try {
            return $this->externalProductCacheRepository->create($data);
        } catch (\Exception $e) {
            throw new ExternalProductCacheException('Failed to create ExternalProductCache', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateExternalProductCache(ExternalProductCache $externalProductCache, array $data)
    {
        try {
            return $this->externalProductCacheRepository->update($externalProductCache, $data);
        } catch (\Exception $e) {
            throw new ExternalProductCacheException('Failed to update ExternalProductCache', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteExternalProductCache(ExternalProductCache $externalProductCache)
    {
        try {
            return $this->externalProductCacheRepository->delete($externalProductCache);
        } catch (\Exception $e) {
            throw new ExternalProductCacheException('Failed to delete ExternalProductCache', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}