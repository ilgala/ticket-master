<?php

namespace App\Services\Contracts;

use App\Models\Attachment;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\FileBag;

interface AttachmentService
{
    public function storeTicketAttachments(FileBag $files, Ticket $ticket): Collection;

    public function storeTicketAttachment(UploadedFile $file, Ticket $ticket): Attachment;
}
