<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    protected $service;
    protected $relations = [
        'role',
        'specialty',
        'specialty.specializables',
        'availabilities.module',
        'role',
        'role.permissions',
        'role.menus'
    ];

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll()->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StoreUserRequest $request)
    {
        return $this->service->create($request->all());
    }

    public function update(UpdateUserRequest $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function findByExternalId(string $externalId): JsonResponse
    {
        try {
            $user = $this->service->getUserByExternalId($externalId)->load($this->relations);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
