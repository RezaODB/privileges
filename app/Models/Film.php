<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Film extends Model
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
     * The chapter this film was filed under, if it was filed under one.
     *
     * @return BelongsTo<Chapter, $this>
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Films shown in the tab's own gallery, rather than inside a chapter.
     *
     * @param  Builder<Film>  $query
     */
    public function scopeOnTheTab(Builder $query): void
    {
        $query->whereNull('chapter_id');
    }

    /**
     * @param  Builder<Film>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    /**
     * The caption in the active locale; films may legitimately have none.
     */
    public function localizedTitle(): ?string
    {
        return $this->{'title_'.app()->getLocale()} ?: $this->title_fr;
    }

    public function url(): string
    {
        return Storage::disk(config('filesystems.media_disk'))->url($this->path);
    }

    public function posterUrl(): ?string
    {
        return $this->poster_path
            ? Storage::disk(config('filesystems.media_disk'))->url($this->poster_path)
            : null;
    }
}
