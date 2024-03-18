<?php

namespace Tests\Unit\Repository;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testItFindsAUserByEmail()
    {
        $user = User::factory()->create();
        $repository = new UserRepository();

        $result = $repository->findBy($user->email);

        $this->assertEquals($user->getKey(), $result->getKey());
        $this->assertEquals($user->email, $result->email);
    }

    public function testItReturnsNullWhenUserIsNotFound()
    {
        $repository = new UserRepository();

        $user = $repository->findBy(fake()->email);

        $this->assertNull($user);
    }
}
