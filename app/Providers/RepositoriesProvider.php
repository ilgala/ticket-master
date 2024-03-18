<?php

namespace App\Providers;

use App\Repositories\Contracts\DepartmentRepository as DepartmentRepositoryContract;
use App\Repositories\Contracts\TicketRepository as TicketRepositoryContract;
use App\Repositories\Contracts\UserRepository as UserRepositoryContract;
use App\Repositories\DepartmentRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        DepartmentRepositoryContract::class => DepartmentRepository::class,
        TicketRepositoryContract::class => TicketRepository::class,
        UserRepositoryContract::class => UserRepository::class,
    ];
}
