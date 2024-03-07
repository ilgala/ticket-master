<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Authentication\JwtGuard;
use App\Authentication\JwtManager;
use App\Authentication\JwtUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            return new JwtGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });

        Auth::provider('jwt', function (Application $app) {
            return new JwtUserProvider($app->make(JwtManager::class));
        });
    }
}
