<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
trait HasUniqueSlug
{
    protected static function bootHasUniqueSlug(): void
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });
    }

    protected static function generateUniqueSlug($title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', $slug.'%')->count();

        // Se il conteggio è maggiore di zero, significa che lo slug esiste già, quindi aggiungi un numero alla fine per renderlo unico
        if ($count > 0) {
            $slug .= '-'.$count;
        }

        return $slug;
    }
}
