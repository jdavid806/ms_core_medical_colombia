<?php

namespace App\Observers;

use App\Enum\TicketPriority;
use App\Models\Ticket;

class TicketObserver
{
    public function creating(Ticket $ticket)
    {
        $ticket->ticket_number = $this->generateTicketNumber($ticket->priority);
    }

    private function generateTicketNumber(TicketPriority $priority): string
    {
        $lastNumber = Ticket::whereDate('created_at', today())
            ->where('priority', $priority)
            ->count();

        return sprintf(
            "%s-%03d",
            $priority->getPriorityPrefix(),
            $lastNumber + 1
        );
    }
}
