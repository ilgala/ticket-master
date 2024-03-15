<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Ticket;
use DB;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Throwable;

class AttachmentService implements Contracts\AttachmentService
{
    public function __construct(
        private readonly FilesystemFactory $factory
    ) {}

    /**
     * @throws Throwable
     */
    public function storeTicketAttachments(FileBag $files, Ticket $ticket): Collection
    {
        return DB::transaction(function () use ($files, $ticket) {
            $attachments = collect();
            foreach ($files->get('attachments') as $file) {
                $attachments->push($this->storeTicketAttachment($file, $ticket));
            }

            return $attachments;
        });
    }

    public function storeTicketAttachment(UploadedFile $file, Ticket $ticket): Attachment
    {
        $attachment = new Attachment([
            'path' => $ticket->slug,
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
        $attachment->ticket()->associate($ticket);

        $this->factory->disk('attachments')->put(
            $attachment->full_path, $file
        );

        return tap($attachment, fn (Attachment $attachment) => $attachment->save());
    }
}
