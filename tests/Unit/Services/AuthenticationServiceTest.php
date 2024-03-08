<?php

namespace Tests\Unit\Services;

use App\Services\AuthenticationService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;
use Mockery\MockInterface;
use Tests\TestCase;
use Tymon\JWTAuth\Factory;

class AuthenticationServiceTest extends TestCase
{
    public function testFailedLoginAttemptThrowsUnauthenticatedException()
    {
        $credentials = ['email' => 'test@test.com', 'password' => 'password'];
        /** @var Guard|MockInterface $guard */
        $guard = $this->mock(Guard::class, function (MockInterface $mock) use ($credentials) {
            $mock->expects('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(null);
        });
        /** @var Factory|MockInterface $factory */
        $factory = $this->mock(Factory::class);

        $service = new AuthenticationService($guard, $factory);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Invalid credentials.');
        $service->attempt($credentials);
    }

    public function testLoginAttemptSucceds()
    {
        $credentials = ['email' => 'test@test.com', 'password' => 'password'];
        $expectedToken = 'foo';
        $expectedTtl = 1;
        /** @var Guard|MockInterface $guard */
        $guard = $this->mock(Guard::class, function (MockInterface $mock) use ($credentials, $expectedToken) {
            $mock->expects('attempt')
                ->once()
                ->with($credentials)
                ->andReturn($expectedToken);
        });
        /** @var Factory|MockInterface $factory */
        $factory = $this->mock(Factory::class, function (MockInterface $mock) use ($expectedTtl) {
            $mock->expects('getTTL')
                ->once()
                ->andReturn($expectedTtl);
        });

        $service = new AuthenticationService($guard, $factory);

        [$token, $ttl] = $service->attempt($credentials);

        $this->assertEquals($expectedToken, $token);
        $this->assertEquals($expectedTtl * config('jwt.ttl'), $ttl);
    }
}
