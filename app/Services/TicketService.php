<?php

namespace App\Services;

use App\Enums\DepartmentCodes;
use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepository;
use App\Services\Contracts\DepartmentService;
use App\Services\Contracts\UserService;

class TicketService implements Contracts\TicketService
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly UserService $userService,
        private readonly DepartmentService $departmentService
    ) {
    }

    public function fetch()
    {
        return $this->ticketRepository->list();
    }

    public function creteFrom(array $data): Ticket
    {
        // 1. Trovo un utente o creo un utente anonimo.
        $user = $this->userService->firstOrCreate($data['email']);

        // 2. Trovo il dipartimento
        $code = $data['code'] instanceof DepartmentCodes
            ? $data['code']
            : DepartmentCodes::from($data['code']);

        $department = $this->departmentService->findBy($code, true);

        // TODO: complete createFrom method and tests.
    }
}
