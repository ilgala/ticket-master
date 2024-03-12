<?php

namespace Tests\Unit\Services;

use App\Events\TicketCreated;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Contracts\TicketRepository;
use App\Services\Contracts\UserService;
use App\Services\TicketService;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    //public function testItCreatesANewTicketFromData()
    //{
    //    $user = User::factory()->create();
    //
    //    /** @var TicketRepository|MockInterface $ticketRepository */
    //    $ticketRepository = $this->mock(TicketRepository::class);
    //
    //    /** @var UserService|MockInterface $userService */
    //    $userService = $this->mock(UserService::class, function (MockInterface $mock) use ($user) {
    //        $mock->expects('firstOrCreate')
    //            ->once()
    //            ->with($user->email)
    //            ->andReturn($user);
    //    });
    //
    //    $service = new TicketService($ticketRepository, $userService);
    //}

    public function testTicketIsStored()
    {
        Event::fake(TicketCreated::class);

        $ticketService = new TicketService(
            $this->createMock(TicketRepository::class)
        );

        $data = [
            'title' => fake()->sentence,
            'body' => fake()->text,
        ];
        $this->assertDatabaseMissing('tickets', $data);

        $result = $ticketService->store(
            $data,
            $user = User::factory()->create(),
            $department = Department::factory()->create()
        );

        $this->assertDatabaseHas('tickets', [
            'id' => $result->getKey(),
            'title' => $result->title,
            'body' => $result->body,
            'creator_id' => $user->getKey(),
            'department_id' => $department->getKey(),
        ]);

        Event::assertDispatched(function (TicketCreated $event) use ($result) {
            return $event->ticket->getKey() === $result->getKey();
        });
    }
}
