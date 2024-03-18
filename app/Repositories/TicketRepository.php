<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @mixin Ticket
 */
class TicketRepository extends Repository implements Contracts\TicketRepository
{
    public function __construct()
    {
        parent::__construct(new Ticket());
    }

    public function list(): LengthAwarePaginator
    {
        return $this->reset()->orderBy('created_at', 'DESC')->paginate(15);
    }

    public function byTitle(string $title): Ticket
    {
        return $this->reset()->whereTitle($title)->first();
    }
}
