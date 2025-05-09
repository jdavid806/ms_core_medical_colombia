<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByExternalId(string $externalId)
    {
        $user = $this->model::where('external_id', $externalId)->first();
        Log::info($user);

        return $user;
    }
    
}