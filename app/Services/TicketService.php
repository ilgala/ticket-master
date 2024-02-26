<?php

namespace App\Services;

class TicketService implements Contracts\TicketService
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {
    }

    public function list()
    {
        return $this->ticketRepository->where('...')->orderBy('created_at', 'DESC')->get();
    }
}
