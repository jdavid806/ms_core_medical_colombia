<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService
{   
    protected $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function getUserByExternalId(string $externalId)
    {
        $user = $this->repository->findByExternalId($externalId);

        if (!$user) {
            throw new ModelNotFoundException("Usuario no encontrado con external_id: {$externalId}");
        }

        return $user;
    }
}
