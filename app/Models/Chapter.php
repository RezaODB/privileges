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
     * The films filed under this chapter, shown when it is opened.
     *
     * @return HasMany<Film, $this>
     */
    public function films(): HasMany
    {
        return $this->hasMany(Film::class);
    }

    /**
     * The gallery to draw when this chapter opens: its own films, or those of
     * its french twin, so a gallery uploaded once shows in both languages.
     *
     * @return \Illuminate\Support\Collection<int, Film>
     */
    public function displayedFilms(): \Illuminate\Support\Collection
    {
        if ($this->films->isNotEmpty() || $this->lang === 'fr') {
            return $this->films;
        }

        return $this->frenchTwin()?->films()->ordered()->get() ?? collect();
    }

    /**
     * The french chapter this one translates, matched on tab, number and the
     * chapter it sits under. Null when she has not numbered them.
     */
    public function frenchTwin(): ?Chapter
    {
        if ($this->lang === 'fr' || ! $this->number) {
            return null;
        }

        return static::query()
            ->where('section_id', $this->section_id)
            ->where('lang', 'fr')
            ->where('number', $this->number)
            ->when(
                $this->parent_id,
                fn (Builder $query) => $query->whereHas(
                    'parent',
                    fn (Builder $parent) => $parent->where('number', $this->parent->number)
                ),
                fn (Builder $query) => $query->topLevel()
            )
            ->first();
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
