<?php

namespace App\Providers;

use App\Services\Contracts\TicketService as TicketServiceContract;
use App\Services\TicketService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    public array $bindings = [
        TicketServiceContract::class => TicketService::class,
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
