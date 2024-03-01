<?php

namespace App\Services\Contracts;

use App\Models\Ticket;

interface TicketService
{
    public function fetch();

    public function creteFrom(array $data): Ticket;
}
