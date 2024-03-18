<?php

namespace Tests\Feature\Assignee;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TicketsByAssigneeTest extends TestCase
{
    use RefreshDatabase;

    private readonly User $assignee;

    protected function setUp(): void
    {
        parent::setUp();

        $department = Department::factory()->create();
        $tickets = Ticket::factory()
            ->count(25)
            ->withMandatoryRelations($department)
            ->withAttachments()
            ->create();
        $this->assignee = User::factory()->create([
            'created_at' => fake()->dateTimeBetween('-10 days', '-2 days'),
        ]);
        $tickets->each(fn (Ticket $ticket) => $ticket->assignees()->attach(
            [$this->assignee->getKey()],
            ['is_owner' => true]
        ));
    }

    public static function pagination(): array
    {
        return [
            [5, 3, 'created_at', 'DESC'],
            [10, 2, 'id', 'DESC'],
            [7, 3, 'title', 'DESC'],
            [4, 3, 'created_at', 'DESC'],
        ];
    }

    public function testAuthenticatedUserIsNotAuthorized()
    {
        $response = $this->getJson(route('assignee.tickets', [
            'assignee' => $this->assignee->email,
        ]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function testRequestSucceed()
    {
        $response = $this->actingAs(User::factory()->create())
            ->getJson(route('assignee.tickets', [
                'assignee' => $this->assignee->email,
            ]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'body',
                    'creator' => [
                        'id', 'email',
                    ],
                    'department' => [
                        'id', 'code', 'name',
                    ],
                    'attachments' => [
                        ['path', 'name', 'mime', 'size', 'fullPath'],
                    ],
                    'createdAt',
                ],
            ],
        ]);
    }

    /**
     * Esempio con data provider
     *
     * @dataProvider pagination
     */
    public function testRequestSucceedWith(int $perPage, int $page, string $order, string $direction)
    {
        $user = User::factory()->create();
        $tickets = Ticket::with(['creator', 'department', 'assignees', 'attachments'])
            ->whereHas(
                'assignees',
                fn ($query) => $query->whereEmail($this->assignee->email)
            )->orderBy($order, $direction)
            ->paginate($perPage, ['*'], 'page', $page);

        $response = $this->actingAs($user)
            ->getJson(route('assignee.tickets', [
                'assignee' => $this->assignee->email,
                'perPage' => $perPage,
                'page' => $page,
                'order' => $order,
                'direction' => $direction,
            ]));

        $response->assertStatus(Response::HTTP_OK);

        collect($tickets->items())->each(function (Ticket $ticket, int $index) use ($response) {
            $response->assertJsonPath("data.{$index}.id", $ticket->id);
            $response->assertJsonPath("data.{$index}.title", $ticket->title);
            $response->assertJsonPath("data.{$index}.body", $ticket->body);
            $response->assertJsonPath("data.{$index}.creator.id", $ticket->creator_id);
        });
    }
}
