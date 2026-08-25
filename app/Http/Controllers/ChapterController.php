<?php

namespace App\Http\Controllers;

use App\Http\EditorHtmlSanitizer;
use App\Models\Chapter;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ChapterController extends Controller
{
    public function index(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.index', [
            'section' => $section,
            'chapters' => $section->chapters()->ordered()->get(),
        ]);
    }

    public function create(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.create', [
            'section' => $section,
            'chapter' => new Chapter,
        ]);
    }

    public function edit(Chapter $chapter): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('chapters.edit', [
            'section' => $chapter->section,
            'chapter' => $chapter,
        ]);
    }

    public function store(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
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
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        if (array_key_exists('body', $data)) {
            $data['body'] = app(EditorHtmlSanitizer::class)->sanitize($data['body']);
        }

        $chapter->update($data);

        return redirect()->route('sections.chapters.index', $chapter->section);
    }

    public function destroy(Chapter $chapter): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $chapter->delete();

        return redirect()->back();
    }
}
