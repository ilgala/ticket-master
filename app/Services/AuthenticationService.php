<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Traits\ForwardsCalls;
use Tymon\JWTAuth\Factory;
use Tymon\JWTAuth\JWTGuard;

/**
 * @mixin JWTGuard
 */
class AuthenticationService implements Contracts\AuthenticationService
{
    use ForwardsCalls;

    protected Guard|JWTGuard $guard;

    public function __construct(
        Guard $guard,
        private readonly Factory $factory
    ) {
        $this->guard = $guard;
    }

    #[\Override]
    public function attempt(array $credentials): array
    {
        if (! $token = $this->guard->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $ttl = $this->factory->getTTL() * config('jwt.ttl');

        return [$token, $ttl];
    }

    public function __call(string $name, array $arguments)
    {
        if (! method_exists($this, $name)) {
            return $this->forwardCallTo($this->guard, $name, $arguments);
        }

        return $this->{$name}(...$arguments);
    }
}
