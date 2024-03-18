<?php

namespace App\Services;

use App\Dto\Pagination;
use App\Events\TicketCreated;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Contracts\TicketRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    public function paginateFor(User $assignee, Pagination $pagination): LengthAwarePaginator
    {
        return $this->ticketRepository->reset()
            ->with(['creator', 'department', 'assignees', 'attachments'])
            ->whereHas('assignees', function (Builder $query) use ($assignee) {
                $query->where('id', $assignee->id);
            })->orderBy(
                $pagination->order,
                $pagination->direction)
            ->paginate(
                $pagination->perPage,
                ['*'],
                $pagination->pageName,
                $pagination->page
            );
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

    /**
     * @throws Throwable
     */
    public function store(array $data, User $creator, Department $department): Ticket
    {
        return DB::transaction(function () use ($data, $creator, $department) {
            $ticket = new Ticket($data);
            $ticket->creator()->associate($creator);
            $ticket->department()->associate($department);

            return tap($ticket, function (Ticket $ticket) {
                $ticket->save();

                event(new TicketCreated($ticket));
            });
        });
    }
}
