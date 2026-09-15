<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
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
     * The chapter this one was filed under, if it is a sub-chapter.
     *
     * @return BelongsTo<Chapter, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'parent_id');
    }

    /**
     * The sub-chapters filed under this one.
     *
     * @return HasMany<Chapter, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Chapter::class, 'parent_id');
    }

    /**
     * @param  Builder<Chapter>  $query
     */
    public function scopeTopLevel(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    /**
     * @param  Builder<Chapter>  $query
     */
    public function scopeForLocale(Builder $query, string $locale): void
    {
        $query->where('lang', $locale);
    }

    /**
     * @param  Builder<Chapter>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }
}
