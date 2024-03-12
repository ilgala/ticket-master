<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Ticket;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\FileBag;

class AttachmentService implements Contracts\AttachmentService
{
    public function storeTicketAttachments(FileBag $files, Ticket $ticket): Collection
    {
        return DB::transaction(function () use ($files, $ticket) {
            $attachments = collect();
            foreach ($files as $file) {
                $attachments->push($this->storeTicketAttachment($file, $ticket));
            }

            return $attachments;
        });
    }

    public function storeTicketAttachment(UploadedFile $file, Ticket $ticket): Attachment
    {
        $file->storeAs(
            $ticket->slug,
            $file->getClientOriginalName(),
            ['disk' => 'attachments']
        );

        $attachment = new Attachment([
            'path' => $ticket->slug,
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
        $attachment->ticket()->associate($ticket);

        return tap($attachment, fn (Attachment $attachment) => $attachment->save());
    }
}
