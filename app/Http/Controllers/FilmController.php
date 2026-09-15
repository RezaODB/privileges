<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Film;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
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
            'films' => $section->films()->ordered()->with('chapter')->get(),
        ]);
    }

    public function create(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('films.create', [
            'section' => $section,
            'film' => new Film,
            'chapters' => $this->chaptersFor($section),
        ]);
    }

    public function edit(Film $film): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('films.edit', [
            'section' => $film->section,
            'film' => $film,
            'chapters' => $this->chaptersFor($film->section),
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
            'chapter_id' => ['nullable', 'integer', $this->chapterRule($section)],
        ]);

        $disk = config('filesystems.media_disk');

        $section->films()->create([
            'title_fr' => $data['title_fr'] ?? null,
            'title_en' => $data['title_en'] ?? null,
            'chapter_id' => $data['chapter_id'] ?? null,
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
            'chapter_id' => ['sometimes', 'nullable', 'integer', $this->chapterRule($film->section)],
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

    /**
     * The chapters of this tab a film may be filed under, both languages, so
     * she can see that a gallery has to be attached on each side.
     *
     * @return Collection<int, Chapter>
     */
    private function chaptersFor(Section $section): Collection
    {
        return $section->chapters()->ordered()->get();
    }

    /**
     * Refuse a chapter belonging to another tab.
     */
    private function chapterRule(Section $section): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($section): void {
            if ($value === null) {
                return;
            }

            $chapter = Chapter::query()->find($value);

            if (! $chapter || ! $chapter->section->is($section)) {
                $fail('Ce chapitre n’appartient pas à cet onglet.');
            }
        };
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
