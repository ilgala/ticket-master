<?php

namespace App\Http\Resources\Department;

use App\Http\Resources\Ticket\Collection as TicketCollection;
use App\Http\Resources\User\Collection as UserCollection;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Department
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
            'code' => $this->code->value,
            'name' => $this->name,
            'tickets' => $this->whenLoaded('tickets', fn () => new TicketCollection($this->tickets)),
            'users' => $this->whenLoaded('users', fn () => new UserCollection($this->users)),
        ];
    }
}
