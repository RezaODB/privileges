<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Figure extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo<Chapter, $this>
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * @param  Builder<Figure>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    /**
     * The number itself, in the active locale, falling back to french.
     */
    public function localizedValue(): string
    {
        return $this->{'value_'.app()->getLocale()} ?: $this->value_fr;
    }

    /**
     * What the number counts, in the active locale, falling back to french.
     */
    public function localizedLabel(): string
    {
        return $this->{'label_'.app()->getLocale()} ?: $this->label_fr;
    }
}
