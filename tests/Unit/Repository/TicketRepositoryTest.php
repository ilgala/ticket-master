<?php

namespace Tests\Unit\Repository;

use App\Models\Ticket;
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
            ->withMandatoryRelations()
            ->create([
                'created_at' => fake()->dateTimeBetween('-30 days'),
            ]);

        $tickets = Ticket::orderBy('created_at', 'DESC')->paginate(15);
        $result = $repository->list();

        $this->assertEquals($tickets, $result);
    }
}
