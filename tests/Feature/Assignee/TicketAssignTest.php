<?php

namespace Tests\Feature\Assignee;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TicketAssignTest extends TestCase
{
    use RefreshDatabase;

    public static function ticketProvider(): array
    {
        return [
            ['ticket', null],
            ['ticket', 123],
            ['ticket', 1.23],
            ['ticket', true],
            ['ticket', false],
            ['ticket', 'not-existing-ticket'],
            ['ticket', ['foo', 'bar']],
        ];
    }

    public static function isOwnerProvider(): array
    {
        return [
            ['isOwner', null],
            ['isOwner', 123],
            ['isOwner', 1.23],
            ['isOwner', 'foo'],
            ['isOwner', ['foo', 'bar']],
        ];
    }

    public function testUnauthenticatedUserIsNotAuthorized()
    {
        $response = $this->putJson(route('assignee.assign-ticket', [
            'assignee' => fake()->email,
        ]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider ticketProvider
     * @dataProvider isOwnerProvider
     */
    public function testRequestMustBeValid(string $input, mixed $value)
    {
        $this->actingAs(User::factory()->create());
        $response = $this->putJson(route('assignee.assign-ticket', [
            'assignee' => User::factory()->create()->email,
        ]), [
            $input => $value,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('ticket');
    }

    public function testRequestSucceeds()
    {
        $user = User::factory()->create();
        $comm = Department::factory()
            ->comm()
            ->create();
        $comm->users()->attach($user->getKey());

        $ticket = Ticket::factory()
            ->withMandatoryRelations($comm)
            ->create();

        $this->actingAs(User::factory()->create());
        $response = $this->putJson(route('assignee.assign-ticket', [
            'assignee' => $user->email,
        ]), [
            'ticket' => $ticket->getKey(),
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'body',
                'assignees' => [
                    ['id', 'email', 'isOwner'],
                ],
                'createdAt',
            ],
        ]);
    }
}
