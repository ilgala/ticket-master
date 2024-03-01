<?php

namespace App\Livewire;

use App\Services\Contracts\TicketService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TicketForm extends Component
{
    #[Validate('required|string|min:5|max:255')]
    public string $title = '';

    #[Validate('required|string|min:5|max:36000')]
    public string $body = '';

    public function render()
    {
        return view('livewire.ticket.form');
    }

    public function create(TicketService $ticketService)
    {
        $this->validate();

        $ticket = $ticketService->creteFrom([
            'title' => $this->title,
            'body' => $this->body
        ]);

        Log::info('Richiamato metodo create');
    }
}
