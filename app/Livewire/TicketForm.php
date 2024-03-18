<?php

namespace App\Livewire;

use App\Enums\DepartmentCodes;
use App\Services\Contracts\TicketService;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TicketForm extends Component
{
    public string $email = '';

    public string $department = '';

    public string $title = '';

    public string $body = '';

    public bool $terms;

    public bool $privacy;

    public ?bool $notify = false;

    public array $files = [];

    protected $listeners = ['fileUploaded'];

    public function render()
    {
        return view('livewire.ticket.form');
    }

    public function fileUploaded(string $path): void
    {
        $this->files[] = $path;
    }

    public function create(TicketService $ticketService)
    {
        $data = $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'department' => ['required', 'string', Rule::enum(DepartmentCodes::class)],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:65535'],
            'terms' => ['required', 'accepted'],
            'privacy' => ['required', 'accepted'],
            'notify' => ['nullable', 'boolean'],
        ]);

        $ticket = $ticketService->creteFrom([
            'files' => $this->files,
            ...$data,
        ]);

        $this->dispatch('showToast', 'success', "Il ticket #{$ticket->title} è stato creato con successo");
    }
}
