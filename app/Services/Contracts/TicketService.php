<?php

namespace App\Services\Contracts;

use App\Dto\Pagination;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

interface TicketService
{
    public function fetch();

    public function paginateFor(User $assignee, Pagination $pagination): LengthAwarePaginator;

    public function creteFrom(array $data): Ticket;

    /**
     * @throws Throwable
     */
    public function store(array $data, User $creator, Department $department): Ticket;
}
