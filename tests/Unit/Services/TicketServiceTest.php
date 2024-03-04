<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Contracts\TicketRepository;
use App\Services\Contracts\UserService;
use App\Services\TicketService;
use Mockery\MockInterface;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    public function testItCreatesANewTicketFromData() {
        $user = User::factory()->create();

        /** @var TicketRepository|MockInterface $ticketRepository */
        $ticketRepository =  $this->mock(TicketRepository::class);

        /** @var UserService|MockInterface $userService */
        $userService = $this->mock(UserService::class, function (MockInterface $mock) use ($user) {
            $mock->expects('firstOrCreate')
                ->once()
                ->with($user->email)
                ->andReturn($user);
        });

        $service = new TicketService($ticketRepository, $userService);
    }
}
