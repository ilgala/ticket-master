<?php

namespace App\Http\Resources\Attachment;

use App\Http\Resources\Ticket\Model as TicketResource;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Attachment
 */
class Model extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'path' => $this->path,
            'name' => $this->name,
            'mime' => $this->mime,
            'size' => $this->size,
            'fullPath' => $this->full_path,
            'ticket' => $this->whenLoaded('ticket', fn () => new TicketResource($this->ticket)),
        ];
    }
}
