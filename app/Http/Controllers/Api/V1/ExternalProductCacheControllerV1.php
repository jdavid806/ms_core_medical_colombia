<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ExternalProductCache;
use App\Filters\ExternalProductCacheFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\ExternalProductCacheService;
use App\Http\Resources\Api\V1\ExternalProductCache\ExternalProductCacheResource;
use App\Http\Requests\Api\V1\ExternalProductCache\StoreExternalProductCacheRequest;
use App\Http\Requests\Api\V1\ExternalProductCache\UpdateExternalProductCacheRequest;

class ExternalProductCacheControllerV1 extends ApiController
{
    public function __construct(private ExternalProductCacheService $externalProductCacheService) {}

    public function index(ExternalProductCacheFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $externalProductCaches = $this->externalProductCacheService->getAllExternalProductCaches($filters, $perPage);

        return $this->ok('ExternalProductCaches retrieved successfully', ExternalProductCacheResource::collection($externalProductCaches));
    }

    public function store(StoreExternalProductCacheRequest $request)
    {
        $externalProductCache = $this->externalProductCacheService->createExternalProductCache($request->validated());
        return $this->ok('ExternalProductCache created successfully', new ExternalProductCacheResource($externalProductCache));
    }

    public function show(ExternalProductCache $externalProductCache)
    {
        return $this->ok('ExternalProductCache retrieved successfully', new ExternalProductCacheResource($externalProductCache));
    }

    public function update(UpdateExternalProductCacheRequest $request, ExternalProductCache $externalProductCache)
    {
        $this->externalProductCacheService->updateExternalProductCache($externalProductCache, $request->validated());
        return $this->ok('ExternalProductCache updated successfully');
    }

    public function destroy(ExternalProductCache $externalProductCache)
    {
        $this->externalProductCacheService->deleteExternalProductCache($externalProductCache);
        return $this->ok('ExternalProductCache deleted successfully');
    }
}