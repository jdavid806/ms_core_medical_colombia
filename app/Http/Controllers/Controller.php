<?php

namespace App\Http\Controllers;

use App\Interfaces\BaseServiceInterface;
use Illuminate\Http\Request;

abstract class Controller
{
    protected $service;
    protected $relations = [];

    public function __construct(BaseServiceInterface $service)
    {
        $this->service = $service;
    }

    public function findByField(Request $request)
    {
        return $this->service
            ->getByColumn($request->field, $request->value)
            ->load($this->relations);
    }

    public function active()
    {
        return $this->service
            ->active()
            ->load($this->relations);
    }

    public function activeCount()
    {
        return $this->service->activeCount();
    }
}
