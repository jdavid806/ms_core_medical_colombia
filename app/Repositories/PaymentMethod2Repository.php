<?php

namespace App\Repositories;

use App\Models\PaymentMethod2;

class PaymentMethod2Repository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(PaymentMethod2 $paymentMethod2)
    {
        parent::__construct($paymentMethod2, self::RELATIONS);
    }
}
