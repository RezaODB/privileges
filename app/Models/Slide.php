<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo<Section, $this>
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @param  Builder<Slide>  $query
     */
    public function scopeForLocale(Builder $query, string $locale): void
    {
        $query->where('lang', $locale);
    }

    /**
     * @param  Builder<Slide>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    public function url(): string
    {
        return Storage::disk(config('filesystems.media_disk'))->url($this->path);
    }
}
