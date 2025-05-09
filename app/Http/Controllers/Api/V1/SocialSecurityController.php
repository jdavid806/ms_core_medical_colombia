<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SocialSecurity;
use App\Http\Controllers\Controller;
use App\Services\SocialSecurityService;
use App\Http\Resources\Api\V1\SocialSecurity\SocialSecurityResource;
use App\Http\Requests\Api\V1\SocialSecurity\StoreSocialSecurityRequest;
use App\Http\Requests\Api\V1\SocialSecurity\UpdateSocialSecurityRequest;

class SocialSecurityController extends Controller
{
    public function __construct(private SocialSecurityService $socialSecurityService) {}

    public function index()
    {
        $socialSecuritys = $this->socialSecurityService->getAllSocialSecuritys();
        return SocialSecurityResource::collection($socialSecuritys);
    }

    public function store(StoreSocialSecurityRequest $request)
    {
        $socialSecurity = $this->socialSecurityService->createSocialSecurity($request->validated());
        return response()->json([
            'message' => 'SocialSecurity created successfully',
            'SocialSecurity' => $socialSecurity,
        ]);
    }

    public function show(SocialSecurity $socialSecurity)
    {
        return new SocialSecurityResource($socialSecurity);
    }

    public function update(UpdateSocialSecurityRequest $request, SocialSecurity $socialSecurity)
    {
        $this->socialSecurityService->updateSocialSecurity($socialSecurity, $request->validated());
        return response()->json([
            'message' => 'SocialSecurity updated successfully',
        ]);
    }

    public function destroy(SocialSecurity $socialSecurity)
    {
        $this->socialSecurityService->deleteSocialSecurity($socialSecurity);
        return response()->json([
            'message' => 'SocialSecurity deleted successfully',
        ]);
    }

    //
}
