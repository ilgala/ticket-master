<?php

namespace Tests\Feature\Ticket;

use App\Events\TicketCreated;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public static function titleProvider(): array
    {
        $title = str_pad('f', 256, 'o');

        return [
            ['title', null],
            ['title', true],
            ['title', false],
            ['title', 123],
            ['title', 123.123],
            ['title', ['foo', 'bar']],
            ['title', 'fo'],
            ['title', $title],
        ];
    }

    public static function bodyProvider(): array
    {
        $body = str_pad('f', 65536, 'o');

        return [
            ['body', null],
            ['body', true],
            ['body', false],
            ['body', 123],
            ['body', 123.123],
            ['body', ['foo', 'bar']],
            ['body', 'fo'],
            ['body', $body],
        ];
    }

    public static function creatorProvider(): array
    {
        return [
            ['creator', null],
            ['creator', true],
            ['creator', false],
            ['creator', 123],
            ['creator', 123.123],
            ['creator', ['foo', 'bar']],
            ['creator', Str::ulid()],
        ];
    }

    public static function departmentProvider(): array
    {
        return [
            ['department', null],
            ['department', true],
            ['department', false],
            ['department', 123],
            ['department', 123.123],
            ['department', ['foo', 'bar']],
            ['department', Str::ulid()],
        ];
    }

    public static function attachmentsProvider(): array
    {
        return [
            ['attachments', true],
            ['attachments', false],
            ['attachments', 123],
            ['attachments', 123.123],
            ['attachments', 'foo'],
        ];
    }

    public static function attachmentProvider(): array
    {
        return [
            ['attachments.0', ['foo', 'bar']],
            ['attachments.1', [UploadedFile::fake(), 'bar']],
            ['attachments.0', [UploadedFile::fake()->create('foo.jpg', 3000), 'bar']],
        ];
    }

    public function testAuthenticatedUserIsNotAuthorized()
    {
        $response = $this->postJson(route('ticket.store'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function testAuthenticatedUserIsAuthorized()
    {
        $response = $this->actingAs(User::factory()->create())
            ->postJson(route('ticket.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title', 'body', 'creator', 'department',
        ]);
    }

    /**
     * @dataProvider titleProvider
     * @dataProvider bodyProvider
     * @dataProvider creatorProvider
     * @dataProvider departmentProvider
     * @dataProvider attachmentsProvider
     */
    //@dataProvider attachmentProvider
    public function testRequestIsValid(string $input, mixed $value)
    {
        $response = $this->actingAs($user = User::factory()->create())
            ->postJson(route('ticket.store'), [
                $input => $value,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor($input);
    }

    public function testRequestSucceeds()
    {
        Event::fake([
            TicketCreated::class,
        ]);

        $user = User::factory()->create();
        $department = Department::factory()->create();
        $response = $this->actingAs(User::factory()->create())
            ->postJson(route('ticket.store'), [
                'title' => fake()->sentence(),
                'body' => fake()->text,
                'creator' => $user->getKey(),
                'department' => $department->getKey(),
            ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'body',
                'creator' => [
                    'id', 'email',
                ],
                'department' => [
                    'id', 'code', 'name',
                ],
                'createdAt',
            ],
        ]);

        Event::assertDispatched(TicketCreated::class);
    }

    public function testRequestSucceedsWithAttachments()
    {
        Storage::fake('attachments');
        Event::fake([
            TicketCreated::class,
        ]);

        $user = User::factory()->create();
        $department = Department::factory()->create();
        $response = $this->actingAs(User::factory()->create())
            ->postJson(route('ticket.store'), [
                'title' => fake()->sentence(),
                'body' => fake()->text,
                'creator' => $user->getKey(),
                'department' => $department->getKey(),
                'attachments' => [
                    UploadedFile::fake()->create('attachment-1.png'),
                    UploadedFile::fake()->create('attachment-2.png'),
                    UploadedFile::fake()->create('attachment-3.png'),
                ],
            ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
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
        ]);

        Event::assertDispatched(TicketCreated::class);
    }
}
