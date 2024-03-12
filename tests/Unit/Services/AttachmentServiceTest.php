<?php

namespace Tests\Unit\Services;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Services\AttachmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class AttachmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testItStoresAnAttachment()
    {
        Storage::fake('attachments');

        $file = UploadedFile::fake()->image('image.jpg');
        $ticket = Ticket::factory()
            ->for(User::factory()->create(), 'creator')
            ->for(Department::factory()->create(), 'department')
            ->create();

        $attachmentService = new AttachmentService();

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

    }
}
