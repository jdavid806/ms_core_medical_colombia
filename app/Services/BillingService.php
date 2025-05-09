<?php

namespace App\Services;

use App\Models\Billing;
use App\Repositories\BillingRepository;

class BillingService
{
    public function __construct(private BillingRepository $billingRepository) {}

    public function getAllBillings()
    {
        return $this->billingRepository->all();
    }

    public function getBillingById(Billing $billing)
    {
        return $this->billingRepository->find($billing);
    }

    public function createBilling(array $data)
    {
        return $this->billingRepository->create($data);
    }

    public function updateBilling(Billing $billing, array $data)
    {
        return $this->billingRepository->update($billing, $data);
    }

    public function deleteBilling(Billing $billing)
    {
        return $this->billingRepository->delete($billing);
    }
}
