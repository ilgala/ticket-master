<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivot\TicketUser
 *
 * @property string $ticket_id
 * @property string $user_id
 * @property bool $is_owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereIsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
class TicketUser extends Pivot
{
    protected $fillable = [
        'is_owner',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
    ];
}
