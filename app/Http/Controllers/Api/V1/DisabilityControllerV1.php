<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\DisabilityFilter;
use App\Models\PatientDisability;
use App\Services\Api\V1\DisabilityService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\Disability\DisabilityResource;
use App\Http\Requests\Api\V1\Disability\StoreDisabilityRequest;
use App\Http\Requests\Api\V1\Disability\UpdateDisabilityRequest;

class DisabilityControllerV1 extends ApiController
{
    public function __construct(private DisabilityService $disabilityService) {}

    public function index(DisabilityFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $disabilitys = $this->disabilityService->getAllDisabilitys($filters, $perPage);

        return $this->ok('Disabilities retrieved successfully', DisabilityResource::collection($disabilitys));
    }

    public function store(StoreDisabilityRequest $request)
    {
        $disability = $this->disabilityService->createDisability($request->validated());
        return $this->ok('Disability created successfully', new DisabilityResource($disability));
    }

    public function show(PatientDisability $disability)
    {
        if ($this->include('clinical_record')) {
            $disability->load('clinicalRecord');
        }
        return $this->ok('Disability retrieved successfully', new DisabilityResource($disability));
    }

    public function update(UpdateDisabilityRequest $request, PatientDisability $disability)
    {
        $this->disabilityService->updateDisability($disability, $request->validated());
        return $this->ok('Disability updated successfully');
    }

    public function destroy(PatientDisability $disability)
    {
        $this->disabilityService->deleteDisability($disability);
        return $this->ok('Disability deleted successfully');
    }
}