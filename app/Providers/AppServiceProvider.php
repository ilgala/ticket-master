<?php

namespace App\Providers;

use App\Authentication\JwtManager;
use App\Services\Contracts\UserService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->singleton(JwtManager::class, function (Application $app) {
            /** @var Repository $config */
            $config = $app->make('config');
            $key = $config->get('auth.jwt_key');

            return new JwtManager(
                $app->make(UserService::class),
                Configuration::forSymmetricSigner(
                    new Sha256(),
                    InMemory::base64Encoded($key)
                )
            );
        });

        $this->app->alias(JwtManager::class, 'jwt-manager');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
