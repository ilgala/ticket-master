<?php

namespace App\Http\Controllers\Authentication;

use App\Dto\Authentication\Jwt;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Login;
use App\Services\Contracts\AuthenticationService;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthenticationService $authenticationService
    ) {
    }

    public function __invoke(Login $request): Jwt
    {
        [$token, $ttl] = $this->authenticationService->attempt(
            $request->validated()
        );

        return new Jwt($token, $ttl);
    }
}
