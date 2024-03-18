<?php

namespace Tests\Unit\Services;

use App\Dto\Pagination;
use App\Events\TicketCreated;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Contracts\TicketRepository;
use App\Services\TicketService;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testServiceReturnsTicketByAssigneeWith20ElementsPerPage()
    {
        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->create();

        Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAssignees()
            ->create();

        $assignee = User::factory()->create();
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$assignee->getKey()],
            ['is_owner' => true]
        ));

        /** @var TicketService $service */
        $service = $this->app->make(TicketService::class);
        $tickets = $service->paginateFor($assignee, new Pagination(
            perPage: 20
        ));

        $this->assertCount(20, $tickets);
        foreach ($tickets as $ticket) {
            $this->assertEquals(1, $ticket->assignees->count());
            $this->assertEquals($assignee->getKey(), $ticket->assignees->first()->getKey());
        }
    }

    public function testServiceReturnsTicketByAssigneeWithSecondPage()
    {
        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->create();

        Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAssignees()
            ->create();

        $assignee = User::factory()->create();
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$assignee->getKey()],
            ['is_owner' => true]
        ));

        /** @var TicketService $service */
        $service = $this->app->make(TicketService::class);
        $tickets = $service->paginateFor($assignee, new Pagination(
            perPage: 20,
            page: 2
        ));

        $this->assertCount(5, $tickets);
    }

    public function testServiceReturnsTicketByAssigneeWithCreatedAtAsOrderColumn()
    {
        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->create();

        Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAssignees()
            ->create();

        $assignee = User::factory()->create([
            'created_at' => fake()->dateTimeBetween('-10 days', '-2 days'),
        ]);
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$assignee->getKey()],
            ['is_owner' => true]
        ));

        /** @var TicketService $service */
        $service = $this->app->make(TicketService::class);
        $tickets = $service->paginateFor($assignee, new Pagination(
            perPage: 20,
            order: 'created_at',
        ))->items();

        $expected = array_pop($tickets);
        while (count($tickets) > 1) {
            $actual = array_pop($tickets);

            $this->assertLessThanOrEqual($expected->created_at, $actual->created_at);
            $expected = $actual;
        }
    }

    public function testServiceReturnsTicketByAssigneeWithCreatedAtAsOrderColumnAndDescAsOrderDirection()
    {
        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->create();

        Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAssignees()
            ->create();

        $assignee = User::factory()->create([
            'created_at' => fake()->dateTimeBetween('-10 days', '-2 days'),
        ]);
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$assignee->getKey()],
            ['is_owner' => true]
        ));

        /** @var TicketService $service */
        $service = $this->app->make(TicketService::class);
        $tickets = $service->paginateFor($assignee, new Pagination(
            perPage: 20,
            order: 'created_at',
            direction: 'DESC',
        ))->items();

        $expected = array_pop($tickets);
        while (count($tickets) > 1) {
            $actual = array_pop($tickets);

            $this->assertGreaterThanOrEqual($expected->created_at, $actual->created_at);
            $expected = $actual;
        }
    }

    public function testServiceReturnsTicketByAssigneeWithSecondPageAndCreatedAtAsOrderColumnAndDescAsOrderDirection()
    {
        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->create();

        Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAssignees()
            ->create();

        $assignee = User::factory()->create([
            'created_at' => fake()->dateTimeBetween('-10 days', '-2 days'),
        ]);
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$assignee->getKey()],
            ['is_owner' => true]
        ));

        /** @var TicketService $service */
        $service = $this->app->make(TicketService::class);
        $tickets = $service->paginateFor($assignee, new Pagination(
            perPage: 20,
            page: 2,
            order: 'created_at',
            direction: 'DESC',
        ))->items();

        $this->assertCount(5, $tickets);

        $expected = array_pop($tickets);
        while (count($tickets) > 1) {
            $actual = array_pop($tickets);

            $this->assertGreaterThanOrEqual($expected->created_at, $actual->created_at);
            $expected = $actual;
        }
    }

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
