<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\Store;
use App\Http\Resources\Ticket\Collection as TicketCollection;
use App\Http\Resources\Ticket\Model as TicketResource;
use App\Services\Contracts\DepartmentService;
use App\Services\Contracts\TicketService;
use App\Services\Contracts\UserService;
use Arr;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService,
        private readonly UserService $userService,
        private readonly DepartmentService $departmentService
    ) {
    }

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

    public function store(Store $request): TicketResource
    {
        $data = $request->validated();
        $user = Arr::pull($data, 'creator');
        $department = Arr::pull($data, 'department');

        $ticket = $this->ticketService->store(
            $data,
            $this->userService->findOrFail($user),
            $this->departmentService->findOrFail($department)
        );

        return new TicketResource($ticket);
    }
}
