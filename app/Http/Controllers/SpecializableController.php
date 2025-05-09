<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpecializableService;

class SpecializableController extends Controller
{
    protected $service;

    public function __construct(SpecializableService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function getBySpeciality($specialityId)
    {
        return $this->service->getBySpecialty($specialityId);
    }
}
