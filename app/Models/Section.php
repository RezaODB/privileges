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
     * @return HasMany<Slide, $this>
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
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
     * The line set in the marker under the page title, if the tab was given one.
     */
    public function localizedSubtitle(): ?string
    {
        return $this->{'subtitle_'.app()->getLocale()} ?: $this->subtitle_fr;
    }

    /**
     * The short account of the whole chapter, shown to the left of the header.
     */
    public function localizedIntro(): ?string
    {
        return $this->{'intro_'.app()->getLocale()} ?: $this->intro_fr;
    }

    /**
     * The quotation set against the intro, on the right of the header.
     */
    public function localizedQuote(): ?string
    {
        return $this->{'quote_'.app()->getLocale()} ?: $this->quote_fr;
    }

    /**
     * Whether the tab was given enough to draw a header at all.
     */
    public function hasHeader(): bool
    {
        return (bool) ($this->number
            || $this->localizedSubtitle()
            || $this->localizedIntro()
            || $this->localizedQuote());
    }

    /**
     * The heading shown above the film gallery, if the tab was given one.
     */
    public function localizedFilmsTitle(): ?string
    {
        return $this->{'films_title_'.app()->getLocale()} ?: $this->films_title_fr;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'shows_quota' => 'boolean',
            'shows_podcasts' => 'boolean',
        ];
    }
}
