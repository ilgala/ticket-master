<?php

namespace App\Http\Resources\User;

use App\Models\Pivot\TicketUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 * @property TicketUser $pivot
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
            'id' => $this->getKey(),
            'email' => $this->email,
            'isOwner' => $this->when($this->hasPivotLoaded('ticket_user'), fn () => $this->pivot->is_owner),
        ];
    }
}
