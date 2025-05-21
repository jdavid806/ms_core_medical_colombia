<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CopaymentRule;
use Illuminate\Support\Facades\Log;
use App\Filters\CopaymentRuleFilter;
use App\Services\Api\V1\CopaymentRuleService;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\CopaymentRule\CopaymentRuleResource;
use App\Http\Requests\Api\V1\CopaymentRule\StoreCopaymentRuleRequest;
use App\Http\Requests\Api\V1\CopaymentRule\UpdateCopaymentRuleRequest;

class CopaymentRuleControllerV1 extends ApiController
{
    public function __construct(private CopaymentRuleService $copaymentRuleService) {}

    public function index(CopaymentRuleFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $copaymentRules = $this->copaymentRuleService->getAllCopaymentRules($filters, $perPage);

        return $this->ok('CopaymentRules retrieved successfully', CopaymentRuleResource::collection($copaymentRules));
    }

    public function store(StoreCopaymentRuleRequest $request)
    {
        $data = $request->validated(); // esto tendrá la clave "rules"


        return response()->json([
            'data' => $this->copaymentRuleService->updateOrCreateRule($data),
            'message' => 'Reglas creadas correctamente'
        ]);
    }


    public function show(CopaymentRule $copaymentRule)
    {
        return $this->ok('CopaymentRule retrieved successfully', new CopaymentRuleResource($copaymentRule));
    }

    public function update(UpdateCopaymentRuleRequest $request, CopaymentRule $copaymentRule)
    {
        $this->copaymentRuleService->updateCopaymentRule($copaymentRule, $request->validated());
        return $this->ok('CopaymentRule updated successfully');
    }

    public function destroy(CopaymentRule $copaymentRule)
    {
        $this->copaymentRuleService->deleteCopaymentRule($copaymentRule);
        return $this->ok('CopaymentRule deleted successfully');
    }
}
