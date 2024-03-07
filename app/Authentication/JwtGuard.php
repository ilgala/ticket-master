<?php

namespace App\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class JwtGuard implements StatefulGuard
{
    protected ?Authenticatable $user = null;

    public function __construct(
        private readonly ?UserProvider $userProvider,
        private readonly Request $request
    ) {
    }

    public function check()
    {
        return $this->user() !== null;
    }

    public function guest()
    {
        return ! $this->check();
    }

    public function user()
    {
        if ($this->hasUser()) {
            return $this->user;
        }

        $bearer = $this->request->bearerToken();

        if (! empty($bearer)) {
            return $this->userProvider->retrieveById($bearer);
        }

        return null;
    }

    public function id()
    {
        if ($this->hasUser()) {
            return $this->user->getAuthIdentifier();
        }

        return null;
    }

    public function validate(array $credentials = [])
    {
        return $this->hasUser();
    }

    public function hasUser()
    {
        return ! is_null($this->user);
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        // TODO: Implement attempt() method.
    }

    public function once(array $credentials = [])
    {
        // TODO: Implement once() method.
    }

    public function login(Authenticatable $user, $remember = false)
    {
        // TODO: Implement login() method.
    }

    public function loginUsingId($id, $remember = false)
    {
        // TODO: Implement loginUsingId() method.
    }

    public function onceUsingId($id)
    {
        // TODO: Implement onceUsingId() method.
    }

    public function viaRemember()
    {
        // TODO: Implement viaRemember() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
