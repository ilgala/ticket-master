<?php

namespace App\Services\Contracts;

use App\Dto\Pagination;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface TicketService
{
    public function fetch();

    /**
     * @throws ModelNotFoundException
     *
     * @codeCoverageIgnore
     */
    public function find(string $id): Ticket;

    public function paginateFor(User $assignee, Pagination $pagination): LengthAwarePaginator;

    public function creteFrom(array $data): Ticket;

    /**
     * @throws Throwable
     */
    public function store(array $data, User $creator, Department $department): Ticket;

    public function assign(User $assignee, Ticket $ticket, bool $isOwner = false): Ticket;
}
