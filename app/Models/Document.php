<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @param  Builder<Document>  $query
     */
    public function scopeForLocale(Builder $query, string $locale): void
    {
        $query->where('lang', $locale);
    }

    /**
     * @param  Builder<Document>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order');
    }

    /**
     * The name the visitor's browser will save the file under.
     */
    public function downloadName(): string
    {
        return Str::slug($this->label).'-'.Str::upper($this->lang).'.pdf';
    }

    public function sizeInBytes(): int
    {
        return Storage::disk(config('filesystems.media_disk'))->exists($this->path)
            ? Storage::disk(config('filesystems.media_disk'))->size($this->path)
            : 0;
    }
}
