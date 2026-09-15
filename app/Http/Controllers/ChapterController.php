<?php

namespace App\Http\Controllers;

use App\Enums\BlockKind;
use App\Http\EditorHtmlSanitizer;
use App\Models\Chapter;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ChapterController extends Controller
{
    public function index(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.index', [
            'section' => $section,
            'chapters' => $section->chapters()
                ->topLevel()
                ->ordered()
                ->with(['children' => fn ($query) => $query->ordered()])
                ->get(),
        ]);
    }

    public function create(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.create', [
            'section' => $section,
            'chapter' => new Chapter,
            'parents' => $this->parentsFor($section),
        ]);
    }

    public function edit(Chapter $chapter): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.edit', [
            'section' => $chapter->section,
            'chapter' => $chapter,
            'parents' => $this->parentsFor($chapter->section, $chapter),
        ]);
    }

    public function store(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'kind' => ['sometimes', 'required', Rule::enum(BlockKind::class)],
            'open' => ['sometimes', 'required', 'boolean'],
            'parent_id' => ['nullable', 'integer', $this->parentRule($section)],
            'body' => ['required', 'string'],
        ]);

        $section->chapters()->create([
            ...$data,
            'body' => app(EditorHtmlSanitizer::class)->sanitize($data['body']),
            'order' => $section->chapters()->max('order') + 1,
        ]);

        return redirect()->route('sections.chapters.index', $section);
    }

    public function update(Chapter $chapter): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'summary' => ['sometimes', 'nullable', 'string'],
            'subtitle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'kind' => ['sometimes', 'required', Rule::enum(BlockKind::class)],
            'open' => ['sometimes', 'required', 'boolean'],
            'parent_id' => ['sometimes', 'nullable', 'integer', $this->parentRule($chapter->section, $chapter)],
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        if (array_key_exists('body', $data)) {
            $data['body'] = app(EditorHtmlSanitizer::class)->sanitize($data['body']);
        }

        $chapter->update($data);

        return redirect()->route('sections.chapters.index', $chapter->section);
    }

    /**
     * The chapters this one may be filed under: same tab, same language, and
     * not themselves already filed under another, so the tree stays two deep.
     *
     * @return Collection<int, Chapter>
     */
    private function parentsFor(Section $section, ?Chapter $chapter = null): Collection
    {
        return $section->chapters()
            ->topLevel()
            ->ordered()
            ->when($chapter?->exists, fn ($query) => $query->whereKeyNot($chapter))
            ->when($chapter?->children()->exists(), fn ($query) => $query->whereRaw('1 = 0'))
            ->get();
    }

    /**
     * Refuse a parent from another tab, another language, or one that is itself
     * a sub-chapter.
     */
    private function parentRule(Section $section, ?Chapter $chapter = null): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($section, $chapter): void {
            if ($value === null) {
                return;
            }

            $parent = Chapter::query()->find($value);
            $lang = request('lang', $chapter?->lang);

            if (! $parent || ! $parent->section->is($section)) {
                $fail('Ce chapitre parent n’appartient pas à cet onglet.');

                return;
            }

            if ($parent->parent_id !== null) {
                $fail('Un sous-chapitre ne peut pas lui-même servir de parent.');

                return;
            }

            if ($lang && $parent->lang !== $lang) {
                $fail('Le chapitre parent doit être dans la même langue.');

                return;
            }

            if ($chapter?->exists && $parent->is($chapter)) {
                $fail('Un chapitre ne peut pas être son propre parent.');

                return;
            }

            if ($chapter?->exists && $chapter->children()->exists()) {
                $fail('Ce chapitre a déjà des sous-chapitres : videz-le avant de le ranger sous un autre.');
            }
        };
    }

    public function destroy(Chapter $chapter): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $chapter->delete();

        return redirect()->back();
    }
}
