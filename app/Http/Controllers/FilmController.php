<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /**
     * @var list<string>
     */
    private const array VIDEO_MIMETYPES = ['video/mp4', 'video/quicktime', 'video/webm'];

    /**
     * @var list<string>
     */
    private const array VIDEO_EXTENSIONS = ['mp4', 'mov', 'webm'];

    public function index(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('films.index', [
            'section' => $section,
            'films' => $section->films()->ordered()->get(),
        ]);
    }

    public function create(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('films.create', [
            'section' => $section,
            'film' => new Film,
        ]);
    }

    public function edit(Film $film): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('films.edit', [
            'section' => $film->section,
            'film' => $film,
        ]);
    }

    public function store(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'title_fr' => ['nullable', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimetypes:'.implode(',', self::VIDEO_MIMETYPES), 'extensions:'.implode(',', self::VIDEO_EXTENSIONS)],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $disk = config('filesystems.media_disk');

        $section->films()->create([
            'title_fr' => $data['title_fr'] ?? null,
            'title_en' => $data['title_en'] ?? null,
            'path' => request()->file('file')->store('films', $disk),
            'poster_path' => request()->file('poster')?->store('films/posters', $disk),
            'order' => $section->films()->max('order') + 1,
        ]);

        return redirect()->route('sections.films.index', $section);
    }

    public function update(Film $film): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'title_fr' => ['sometimes', 'nullable', 'string', 'max:255'],
            'title_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'order' => ['sometimes', 'required', 'integer'],
            'file' => ['sometimes', 'file', 'mimetypes:'.implode(',', self::VIDEO_MIMETYPES), 'extensions:'.implode(',', self::VIDEO_EXTENSIONS)],
            'poster' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $disk = config('filesystems.media_disk');

        if (request()->hasFile('file')) {
            Storage::disk($disk)->delete($film->path);
            $data['path'] = request()->file('file')->store('films', $disk);
        }

        if (request()->hasFile('poster')) {
            if ($film->poster_path) {
                Storage::disk($disk)->delete($film->poster_path);
            }
            $data['poster_path'] = request()->file('poster')->store('films/posters', $disk);
        }

        unset($data['file'], $data['poster']);

        $film->update($data);

        return redirect()->route('sections.films.index', $film->section);
    }

    public function destroy(Film $film): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        Storage::disk(config('filesystems.media_disk'))->delete(array_filter([
            $film->path,
            $film->poster_path,
        ]));

        $film->delete();

        return redirect()->back();
    }
}
