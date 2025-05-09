<?php

namespace App\Services\Api\V2;


use Illuminate\Http\Response;
use App\Models\SocialSecurity;
use App\Exceptions\SocialSecurityException;
use App\Repositories\SocialSecurityRepository;

class SocialSecurityServiceV2
{
    public function __construct(private SocialSecurityRepository $socialSecurityRepository) {}

    public function getAllSocialSecuritys($filters, $perPage)
    {
        try {
            return SocialSecurity::filter($filters)->paginate($perPage);

        } catch (\Exception $e) {
            throw new SocialSecurityException('Failed to retrieve SocialSecurities', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSocialSecurityById(SocialSecurity $socialSecurity)
    {
        $result = $this->socialSecurityRepository->find($socialSecurity);
        if (!$result) {
            throw new SocialSecurityException('SocialSecurity not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createSocialSecurity(array $data)
    {
        try {
            return $this->socialSecurityRepository->create($data);
        } catch (\Exception $e) {
            throw new SocialSecurityException('Failed to create SocialSecurity', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateSocialSecurity(SocialSecurity $socialSecurity, array $data)
    {
        try {
            return $this->socialSecurityRepository->updateModel($socialSecurity, $data);
        } catch (\Exception $e) {
            throw new SocialSecurityException('Failed to update SocialSecurity', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSocialSecurity(SocialSecurity $socialSecurity)
    {
        try {
            return $this->socialSecurityRepository->deleteModel($socialSecurity);
        } catch (\Exception $e) {
            throw new SocialSecurityException('Failed to delete SocialSecurity', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}