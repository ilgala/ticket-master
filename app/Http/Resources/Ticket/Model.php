<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Department\Model as DepartmentResource;
use App\Http\Resources\User\Collection as UserCollection;
use App\Http\Resources\User\Model as UserResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Ticket
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
            'title' => $this->title,
            'body' => $this->body,
            'creator' => $this->whenLoaded('creator', fn () => new UserResource($this->creator)),
            'department' => $this->whenLoaded('department', fn () => new DepartmentResource($this->department)),
            'assignees' => $this->whenLoaded('assignees', fn () => new UserCollection($this->assignees)),
            'createdAt' => $this->created_at->toISOString(),
        ];
    }
}
