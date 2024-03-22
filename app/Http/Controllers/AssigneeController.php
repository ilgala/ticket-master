<?php

namespace App\Http\Controllers;

use App\Dto\Pagination;
use App\Http\Requests\TicketAssign;
use App\Http\Resources\Ticket\Collection as TicketCollection;
use App\Http\Resources\Ticket\Model as TicketResource;
use App\Models\User;
use App\Services\Contracts\TicketService;
use Illuminate\Http\Request;

class AssigneeController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService
    ) {
    }

    public function tickets(Request $request, User $assignee): TicketCollection
    {
        $pagination = Pagination::from($request);
        $tickets = $this->ticketService->paginateFor($assignee, $pagination);

        return new TicketCollection($tickets);
    }

    public function assignTicket(TicketAssign $request, User $assignee): TicketResource
    {
        $ticket = $this->ticketService->assign(
            $assignee,
            $this->ticketService->find($request->input('ticket')),
            $request->input('isOwner', false)
        );

        return new TicketResource($ticket);
    }
}
