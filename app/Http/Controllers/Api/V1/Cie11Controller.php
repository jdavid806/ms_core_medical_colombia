<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Cie11Service;

class Cie11Controller extends Controller
{
    public function __construct(private Cie11Service $cie11Service) {}

    public function getByCode($code)
    {
        return $this->cie11Service->getByCode($code);
    }

    public function getByName($name)
    {
        return $this->cie11Service->getByName($name);
    }
}
