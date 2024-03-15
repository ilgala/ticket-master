<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\Store;
use App\Http\Resources\Ticket\Model as TicketResource;
use App\Services\Contracts\AttachmentService;
use App\Services\Contracts\DepartmentService;
use App\Services\Contracts\TicketService;
use App\Services\Contracts\UserService;
use Arr;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService,
        private readonly UserService $userService,
        private readonly DepartmentService $departmentService,
        private readonly AttachmentService $attachmentService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function store(Store $request): TicketResource
    {
        $data = $request->validated();
        $user = Arr::pull($data, 'creator');
        $department = Arr::pull($data, 'department');

        // La transaction è superflua dato che se salta il file upload, non è necessario
        // il rollback di tutti i dati. Il ticket lo teniamo comunque!
        //DB::transaction(function () use ($user, $department, $data, $request) {
        $ticket = $this->ticketService->store(
            $data,
            $this->userService->findOrFail($user),
            $this->departmentService->findOrFail($department),
        );

        if ($request->files->has('attachments')) {
            $this->attachmentService->storeTicketAttachments(
                $request->files, $ticket
            );

            $ticket->loadMissing(['attachments']);
        }
        //});

        return new TicketResource($ticket);
    }
}
