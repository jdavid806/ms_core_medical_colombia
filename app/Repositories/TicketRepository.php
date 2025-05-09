<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository extends BaseRepository
{
    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }
}
