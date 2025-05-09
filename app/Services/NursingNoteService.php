<?php

namespace App\Services;

use App\Repositories\NursingNoteRepository;

class NursingNoteService extends OneToManyService
{
    protected $repository;

    public function __construct(NursingNoteRepository $repository)
    {
        $this->repository = $repository;
    }
}
