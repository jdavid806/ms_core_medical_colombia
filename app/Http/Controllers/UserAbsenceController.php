<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAbsence\StoreUserAbsenceRequest;
use App\Http\Requests\UserAbsence\UpdateUserAbsenceRequest;
use App\Services\UserAbsenceService;

class UserAbsenceController extends Controller
{
    protected $service;
    protected $relations = ['user'];

    public function __construct(UserAbsenceService $service)
    {
        $this->service = $service;
    }

    public function index($userId)
    {
        return $this->service->ofParent($userId)->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StoreUserAbsenceRequest $request, $userId)
    {
        return $this->service->createForParent($userId, $request->validated());
    }

    public function update(UpdateUserAbsenceRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
