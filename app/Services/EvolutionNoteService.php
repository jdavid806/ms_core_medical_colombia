<?php

namespace App\Services;

use App\Repositories\EvolutionNoteRepository;



class EvolutionNoteService 
{
    public function __construct(private EvolutionNoteRepository $evolutionNoteRepository) {}

    public function createEvolutionNote(array $data)
    {
        return $this->evolutionNoteRepository->create($data);
    }
}

