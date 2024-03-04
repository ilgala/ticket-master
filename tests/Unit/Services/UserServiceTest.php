<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testItFindsUserByEmail()
    {
        $user = User::factory()->create();

        /** @var UserRepository|MockInterface $repository */
        $repository = $this->mock(UserRepository::class, function (MockInterface $mock) use ($user) {
            $mock->expects('findBy')
                ->once()
                ->with($user->email)
                ->andReturn($user);
        });

        $service = new UserService($repository);
        $result = $service->findBy($user->email, true);

        $this->assertEquals($user, $result);

        $this->assertEquals($user->getKey(), $result->getKey());
        $this->assertEquals($user->email, $result->email);
    }

    public function testItReturnsNullWhenUserIsNotFound()
    {
        $email = fake()->email;
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        /** @var UserRepository|MockInterface $repository */
        $repository = $this->mock(UserRepository::class, function (MockInterface $mock) use ($email) {
            $mock->expects('findBy')
                ->once()
                ->with($email)
                ->andReturnNull();
        });
        $service = new UserService($repository);

        $result = $service->findBy($email, false);
        $this->assertNull($result);
    }

    public function testItThrowsModelNotFoundExceptionWhenUserIsNotFound()
    {
        $email = fake()->email;
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        /** @var UserRepository|MockInterface $repository */
        $repository = $this->mock(UserRepository::class, function (MockInterface $mock) use ($email) {
            $mock->expects('findBy')
                ->once()
                ->with($email)
                ->andReturnNull();
        });
        $service = new UserService($repository);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Can't find user by email $email");

        $service->findBy($email, true);
    }

    public function testItCreatesANewUserFromEmail()
    {
        $email = fake()->email;
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        /** @var UserRepository|MockInterface $repository */
        $repository = $this->mock(UserRepository::class, function (MockInterface $mock) use ($email) {
            $mock->expects('findBy')
                ->once()
                ->with($email)
                ->andReturnNull();

            $mock->expects('store')
                ->once()
                ->with([
                    'username' => 'Utente anonimo',
                    'email' => $email,
                    'password' => '-',
                ])->andReturn(new User);
        });
        $service = new UserService($repository);

        $user = $service->firstOrCreate($email);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testItFindsUserFromEmailWithoutCreatingANewOne()
    {
        $user = User::factory()->create();

        /** @var UserRepository|MockInterface $repository */
        $repository = $this->mock(UserRepository::class, function (MockInterface $mock) use ($user) {
            $mock->expects('findBy')
                ->once()
                ->with($user->email)
                ->andReturn($user);
        });
        $service = new UserService($repository);

        $result = $service->firstOrCreate($user->email);

        $this->assertEquals($user, $result);
    }
}
