<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Department\DepartmentResource;
use App\Http\Requests\Api\V1\Department\StoreDepartmentRequest;
use App\Http\Requests\Api\V1\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $departmentService) {}

    public function index()
    {
        $departments = $this->departmentService->getAllDepartments();
        return DepartmentResource::collection($departments);
    }

    public function departmentsByCountry($country)
    {
        return $this->departmentService->getStatesByCountry($country);
    }
}
