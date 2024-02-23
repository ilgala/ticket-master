<?php

namespace App\Http\Controllers;

use App\Http\Resources\Ticket\Collection as TicketCollection;
use App\Services\Contracts\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService
    ) {}

    public function createdBy(Request $request): TicketCollection
    {
        $tickets = $this->ticketService->fetch();

        return new TicketCollection($tickets);
    }
    public function assignedTo(Request $request): TicketCollection
    {
        $tickets = $this->ticketService->fetch();

        return new TicketCollection($tickets);
    }
    public function byDepartment(Request $request): TicketCollection
    {
        $tickets = $this->ticketService->fetch();

        return new TicketCollection($tickets);
    }
}
