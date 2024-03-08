<?php

namespace App\Providers;

use App\Services\AuthenticationService;
use App\Services\Contracts\AuthenticationService as AuthenticationServiceContract;
use App\Services\Contracts\DepartmentService as DepartmentServiceContract;
use App\Services\Contracts\TicketService as TicketServiceContract;
use App\Services\Contracts\UserService as UserServiceContract;
use App\Services\DepartmentService;
use App\Services\TicketService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    public array $bindings = [
        AuthenticationServiceContract::class => AuthenticationService::class,
        DepartmentServiceContract::class => DepartmentService::class,
        TicketServiceContract::class => TicketService::class,
        UserServiceContract::class => UserService::class,
    ];

    //public $singletons = [
    //    TicketServiceContract::class => TicketService::class,
    //];

    ///**
    // * Register services.
    // */
    //public function register(): void
    //{
    //    $this->app->bind(TicketServiceContract::class, TicketService::class);
    //    $this->app->singleton(TicketServiceContract::class, TicketService::class);
    //}

    ///**
    // * Bootstrap services.
    // */
    //public function boot(): void
    //{
    //
    //}
}
