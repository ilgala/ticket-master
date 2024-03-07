<?php

namespace App\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class JwtUserProvider implements UserProvider
{
    public function __construct(
        private readonly JwtManager $jwtManager
    ) {
    }

    public function retrieveById($identifier)
    {
        return $this->jwtManager->fetchBy($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->jwtManager->fetchBy($identifier);
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // DOES NOTHING
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->jwtManager->byCredentials($credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }
}
