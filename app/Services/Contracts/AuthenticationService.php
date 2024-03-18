<?php

namespace App\Services\Contracts;

use Tymon\JWTAuth\JWTGuard;

/**
 * @mixin JWTGuard
 */
interface AuthenticationService
{
    /**
     * @throw AuthenticationException
     */
    public function attempt(array $credentials): array;
}
