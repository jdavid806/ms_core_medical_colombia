<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\SocialSecurity;
use App\Filters\SocialSecurityFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V2\SocialSecurityServiceV2;
use App\Http\Resources\Api\V2\SocialSecurity\SocialSecurityResourceV2;
use App\Http\Requests\Api\V2\SocialSecurity\StoreSocialSecurityRequestV2;
use App\Http\Requests\Api\V2\SocialSecurity\UpdateSocialSecurityRequestV2;
use Illuminate\Http\Request;

class SocialSecurityControllerV2 extends ApiController
{
    public function __construct(private SocialSecurityServiceV2 $socialSecurityService) {}

    public function index(SocialSecurityFilter $filters)
    {

        $perPage = request()->input('per_page', 10);
        
        $socialSecuritys = $this->socialSecurityService->getAllSocialSecuritys($filters, $perPage);
        
        return $this->ok('SocialSecuritys retrieved successfully', SocialSecurityResourceV2::collection($socialSecuritys));
    }

    public function store(StoreSocialSecurityRequestV2 $request)
    {

        $socialSecurity = $this->socialSecurityService->createSocialSecurity($request->validated());
        return $this->ok('SocialSecurity created successfully', new SocialSecurityResourceV2($socialSecurity));
    }

    public function show(SocialSecurity $social_security)
    {
        return $this->ok('SocialSecurity retrieved successfully', new SocialSecurityResourceV2($social_security));
    }

    public function update(UpdateSocialSecurityRequestV2 $request, SocialSecurity $social_security)
    {
        $this->socialSecurityService->updateSocialSecurity($social_security, $request->validated());
        return $this->ok('SocialSecurity updated successfully');
    }

    public function destroy(SocialSecurity $social_security)
    {
        $this->socialSecurityService->deleteSocialSecurity($social_security);
        return $this->ok('SocialSecurity deleted successfully');
    }
}