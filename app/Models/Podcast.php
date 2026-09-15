<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Podcast extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @param  Builder<Podcast>  $query
     */
    public function scopeForLocale(Builder $query, string $locale): void
    {
        $query->where('lang', $locale);
    }

    /**
     * @param  Builder<Podcast>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    /**
     * Uploads live on the media disk under podcasts/. The four original files
     * predate this table and still sit at the public root; they are recognised
     * by having no directory in their path, and this branch can go once they
     * have been re-uploaded.
     */
    public function url(): string
    {
        return str_contains($this->path, '/')
            ? Storage::disk(config('filesystems.media_disk'))->url($this->path)
            : asset($this->path);
    }

    /**
     * A stable set of bar heights for the waveform, derived from the id so a
     * podcast always draws the same shape. Decorative: it is not read from the
     * audio, only the progress over it is real.
     *
     * @return list<int>
     */
    public function waveform(int $bars = 90): array
    {
        mt_srand($this->id ?: 1);

        $heights = [];

        for ($bar = 0; $bar < $bars; $bar++) {
            $heights[] = mt_rand(18, 100);
        }

        mt_srand();

        return $heights;
    }
}
