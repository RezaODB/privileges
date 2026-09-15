<?php

namespace App\Http\Controllers;

use App\Http\EditorHtmlSanitizer;
use App\Models\Section;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('slides.index', [
            'section' => $section,
            'slides' => $section->slides()->orderBy('lang')->ordered()->get()->groupBy('lang'),
        ]);
    }

    public function create(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('slides.create', [
            'section' => $section,
        ]);
    }

    /**
     * Store a whole carousel at once: the files are numbered in the order they were picked.
     */
    public function store(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        request()->validate([
            'lang' => ['required', 'in:fr,en'],
            'files' => ['required', 'array'],
            'files.*' => ['image', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $lang = request('lang');
        $disk = config('filesystems.media_disk');
        $order = $section->slides()->forLocale($lang)->max('order') ?? 0;

        foreach (request()->file('files') as $file) {
            [$width, $height] = getimagesize($file->getRealPath()) ?: [null, null];

            $section->slides()->create([
                'lang' => $lang,
                'order' => ++$order,
                'path' => $file->store('slides', $disk),
                'width' => $width,
                'height' => $height,
            ]);
        }

        return redirect()->route('sections.slides.index', $section);
    }

    public function write(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('slides.write', [
            'section' => $section,
            'slide' => new Slide,
        ]);
    }

    public function edit(Slide $slide): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('slides.edit', [
            'section' => $slide->section,
            'slide' => $slide,
        ]);
    }

    public function storeText(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['required', 'in:fr,en'],
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $section->slides()->create([
            ...$data,
            'body' => app(EditorHtmlSanitizer::class)->sanitize($data['body']),
            'order' => ($section->slides()->forLocale($data['lang'])->max('order') ?? 0) + 1,
        ]);

        return redirect()->route('sections.slides.index', $section);
    }

    public function update(Slide $slide): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'order' => ['sometimes', 'required', 'integer'],
            'lang' => ['sometimes', 'required', 'in:fr,en'],
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
        ]);

        if (array_key_exists('body', $data)) {
            $data['body'] = app(EditorHtmlSanitizer::class)->sanitize($data['body']);
        }

        $slide->update($data);

        return redirect()->route('sections.slides.index', $slide->section);
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        if ($slide->path) {
            Storage::disk(config('filesystems.media_disk'))->delete($slide->path);
        }

        $slide->delete();

        return redirect()->back();
    }
}
