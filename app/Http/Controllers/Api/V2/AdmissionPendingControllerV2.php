<?php

namespace App\Http\Controllers\Api\V2;

use App\Filters\AdmissionFilter;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\V2\AdmissionPendingServiceV2;
use App\Http\Resources\Api\V2\AdmissionPending\AdmissionPendingResourceV2;
use App\Http\Requests\Api\V2\AdmissionPending\StoreAdmissionPendingRequestV2;
use App\Http\Requests\Api\V2\AdmissionPending\UpdateAdmissionPendingRequestV2;

class AdmissionPendingControllerV2 extends ApiController
{
    public function __construct(private AdmissionPendingServiceV2 $admissionPendingServiceV2) {}

    /* public function index(AdmissionFilter $filters)
    {
        $perPage = request()->get('per_page', 10);
    
        $paginatedAdmissions = $this->admissionPendingServiceV2->getFilteredPendingAdmissions($filters, $perPage);

        return $this->ok('Admissions found', AdmissionPendingResourceV2::collection($paginatedAdmissions));
    } */

    public function index()
    {
        $admissionPendings = $this->admissionPendingServiceV2->getAllAdmissionPendings();
        return AdmissionPendingResourceV2::collection($admissionPendings);
    }

    /*   

    
    public function store(StoreAdmissionPendingRequestV2 $request)
    {
        $admissionPending = $this->admissionPendingServiceV2->createAdmissionPending($request->validated());
        return response()->json([
            'message' => 'AdmissionPending created successfully',
            'AdmissionPending' => $admissionPending,
        ]);
    }

     public function show(AdmissionPending $admissionPending)
    {
        return new AdmissionPendingResourceV2($admissionPending);
    }

    public function update(UpdateAdmissionPendingRequestV2 $request, AdmissionPending $admissionPending)
    {
        $this->admissionPendingServiceV2->updateAdmissionPending($admissionPending, $request->validated());
        return response()->json([
            'message' => 'AdmissionPending updated successfully',
        ]);
    }

    public function destroy(AdmissionPending $admissionPending)
    {
        $this->admissionPendingServiceV2->deleteAdmissionPending($admissionPending);
        return response()->json([
            'message' => 'AdmissionPending deleted successfully',
        ]);
    } */

    //
}
