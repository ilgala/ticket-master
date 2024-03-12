<?php

namespace Tests\Unit\Repository;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\TicketRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function testItRetrievesAPaginatedListOfTickets(): void
    {
        $repository = new TicketRepository();

        Ticket::factory(20)
            ->for(User::factory(), 'creator')
            ->for(Department::factory(), 'department')
            ->create([
                'created_at' => fake()->dateTimeBetween('-30 days'),
            ]);

        $tickets = Ticket::orderBy('created_at', 'DESC')->paginate(15);
        $result = $repository->list();

        $this->assertEquals($tickets, $result);
    }
}
