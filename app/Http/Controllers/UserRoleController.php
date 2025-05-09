<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRole\StoreUserRoleRequest;
use App\Http\Requests\UserRole\UpdateUserRoleRequest;
use App\Services\UserRoleService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected $service;
    protected $relations = ['permissions', 'menus'];

    public function __construct(UserRoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->getAll()
            ->load($this->relations);
    }

    public function show($id)
    {
        return $this->service
            ->getById($id)
            ->load($this->relations);
    }

    public function store(StoreUserRoleRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateUserRoleRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function storeWithMenusAndPermissions(Request $request)
    {
        return $this->service->storeWithMenusAndPermissions($request->all());
    }

    public function updateWithMenusAndPermissions(Request $request, $id)
    {
        return $this->service->updateWithMenusAndPermissions($id, $request->all());
    }
}
