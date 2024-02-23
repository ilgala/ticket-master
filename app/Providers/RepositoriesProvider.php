<?php

namespace App\Providers;

use App\Repositories\Contracts\TicketRepository as TicketRepositoryContract;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        TicketRepositoryContract::class => TicketRepository::class,
    ];
}
