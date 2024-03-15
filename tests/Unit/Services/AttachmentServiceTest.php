<?php

namespace Tests\Unit\Services;

use App\Models\Ticket;
use App\Services\AttachmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Storage;
use Symfony\Component\HttpFoundation\FileBag;
use Tests\TestCase;

class AttachmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testItStoresAnAttachment()
    {
        Storage::fake('attachments');

        $file = UploadedFile::fake()->image('image.jpg');
        $ticket = Ticket::factory()
            ->withMandatoryRelations()
            ->create();

        $this->assertDatabaseMissing('attachments', [
            'ticket_id' => $ticket->id,
            'path' => $ticket->slug,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
        ]);
        Storage::disk('attachments')
            ->assertMissing("{$ticket->slug}/{$file->getClientOriginalName()}");

        $attachmentService = new AttachmentService(
            $this->app['filesystem'],
        );
        $attachmentService->storeTicketAttachment($file, $ticket);

        Storage::disk('attachments')
            ->assertExists("{$ticket->slug}/{$file->getClientOriginalName()}");
        $this->assertDatabaseHas('attachments', [
            'ticket_id' => $ticket->id,
            'path' => $ticket->slug,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
        ]);
    }

    public function testItStoresMultipleAttachments()
    {
        Storage::fake('attachments');

        $files = [
            'attachments' => [
                UploadedFile::fake()->image('image-1.jpg'),
                UploadedFile::fake()->image('image-2.jpg'),
            ],
        ];
        $ticket = Ticket::factory()
            ->withMandatoryRelations()
            ->create();

        $attachmentService = new AttachmentService(
            $this->app['filesystem'],
        );
        $attachmentService->storeTicketAttachments(new FileBag($files), $ticket);

        foreach ($files['attachments'] as $file) {
            Storage::disk('attachments')
                ->assertExists("{$ticket->slug}/{$file->getClientOriginalName()}");
        }
        $this->assertCount(2, $ticket->attachments);

    }
}
