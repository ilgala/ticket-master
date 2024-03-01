<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepository;

class TicketService implements Contracts\TicketService
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {
    }

    public function fetch()
    {
        return $this->ticketRepository->list();
    }

    public function creteFrom(array $data): Ticket
    {
        return $this->ticketRepository->save(new Ticket(), $data);
    }
}
