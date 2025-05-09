<?php

namespace App\Services;

use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Events\Tickets\TicketCalled;
use App\Events\Tickets\TicketGenerated;
use App\Events\Tickets\TicketStateUpdated;
use App\Helpers\EntityDiffHelper;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\DB;

class TicketService extends BaseService
{
    protected $repository;
    protected $relations = ['branch'];

    public function __construct(TicketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $ticket = parent::create($data);
            $ticket->load($this->relations);

            TicketGenerated::dispatch(
                $ticket,
                app('X-Domain-Global'),
                $ticket->branch_id
            );

            return $ticket;
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $ticket = $this->repository->find($id);
            $mergedData = array_merge($ticket->toArray(), $data);
            $changes = EntityDiffHelper::detectChanges($ticket->toArray(), $mergedData);

            $ticket = $this->repository->update($id, $data);

            if (isset($changes['status'])) {
                $ticket->load($this->relations);
                TicketStateUpdated::dispatch(
                    $ticket->id,
                    app('X-Domain-Global'),
                    $ticket->branch_id,
                    $ticket->status,
                    $ticket->module_id
                );
            }

            return $ticket;
        });
    }

    public function getTicketsByReasons($reasons)
    {
        return Ticket::whereIn('reason', $reasons)
            ->orderByRaw('
            CASE priority
                WHEN ? THEN 1   -- Máxima prioridad: PREGNANT
                WHEN ? THEN 2   -- SENIOR
                WHEN ? THEN 3   -- DISABILITY
                WHEN ? THEN 4   -- CHILDREN_BABY
                ELSE 5          -- NONE (prioridad normal)
            END
        ', [
                TicketPriority::PREGNANT->value,
                TicketPriority::SENIOR->value,
                TicketPriority::DISABILITY->value,
                TicketPriority::CHILDREN_BABY->value
            ])
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at')
            ->get();
    }
}
