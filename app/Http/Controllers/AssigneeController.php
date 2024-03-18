<?php

namespace App\Http\Controllers;

use App\Dto\Pagination;
use App\Http\Resources\Ticket\Collection as TicketCollection;
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
}
