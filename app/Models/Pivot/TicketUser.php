<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivot\TicketUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketUser query()
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
