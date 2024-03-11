<?php

namespace App\Services;

use App\Enums\DepartmentCodes;
use App\Events\TicketCreated;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Contracts\TicketRepository;
use App\Services\Contracts\DepartmentService;
use App\Services\Contracts\UserService;

class TicketService implements Contracts\TicketService
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        // private readonly UserService $userService,
        // private readonly DepartmentService $departmentService
    ) {
    }

    public function fetch()
    {
        return $this->ticketRepository->list();
    }

    public function creteFrom(array $data): Ticket
    {
        // TODO: homework, to be completed
        // 1. Trovo un utente o creo un utente anonimo.
        //$user = $this->userService->firstOrCreate($data['email']);

        // 2. Trovo il dipartimento
        //$code = $data['code'] instanceof DepartmentCodes
        //    ? $data['code']
        //    : DepartmentCodes::from($data['code']);

        //$department = $this->departmentService->findBy($code, true);

        //return $this->store($data, $user, $department);

        return new Ticket();
    }

    public function store(array $data, User $creator, Department $department): Ticket
    {
        $ticket = new Ticket($data);
        $ticket->creator()->associate($creator);
        $ticket->department()->associate($department);

        return tap($ticket, function (Ticket $ticket) {
            $ticket->save();

            event(new TicketCreated($ticket));
        });
    }
}
