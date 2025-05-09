<?php

namespace App\Services;

use App\Models\SocialSecurity;
use App\Repositories\SocialSecurityRepository;

class SocialSecurityService
{
    public function __construct(private SocialSecurityRepository $socialSecurityRepository) {}

    public function getAllSocialSecuritys()
    {
        return $this->socialSecurityRepository->all();
    }

    /* public function getSocialSecurityById(SocialSecurity $socialSecurity)
    {
        return $this->socialSecurityRepository->find($socialSecurity);
    } */

    public function createSocialSecurity(array $data)
    {
        return $this->socialSecurityRepository->create($data);
    }

    public function getSocialSecurityById($id)
{
    return $this->socialSecurityRepository->find($id);
}

    public function deleteSocialSecurity(SocialSecurity $socialSecurity)
    {
        return $this->socialSecurityRepository->delete($socialSecurity);
    }

    public function updateSocialSecurity(SocialSecurity $socialSecurity, array $data)
    {
        $socialSecurity->update($data);
        return $socialSecurity;
    }
}
