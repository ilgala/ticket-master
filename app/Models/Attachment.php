<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string $ticket_id
 * @property string $path
 * @property string $name
 * @property string $mime
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $full_path
 * @property-read mixed $get_file
 * @property-read \App\Models\Ticket $ticket
 *
 * @method static \Database\Factories\AttachmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Attachment extends BaseModel
{
    protected $fillable = [
        'path',
        'name',
        'mime',
        'size',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function fullPath(): Attribute
    {
        return Attribute::make(
            fn () => "$this->path/$this->name"
        );
    }

    public function getFile(): Attribute
    {
        return Attribute::make(
            fn () => Storage::get($this->fullPath)
        );
    }
}
