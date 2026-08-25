<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasMany<Chapter, $this>
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     * @return HasMany<Film, $this>
     */
    public function films(): HasMany
    {
        return $this->hasMany(Film::class);
    }

    /**
     * @param  Builder<Section>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    /**
     * @param  Builder<Section>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    /**
     * The tab label in the currently active locale, falling back to French.
     */
    public function localizedTitle(): string
    {
        return $this->{'title_'.app()->getLocale()} ?: $this->title_fr;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'shows_quota' => 'boolean',
        ];
    }
}
