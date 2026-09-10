<?php

namespace App\Http\Controllers;

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

    public function update(Slide $slide): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'order' => ['required', 'integer'],
        ]);

        $slide->update($data);

        return redirect()->route('sections.slides.index', $slide->section);
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        Storage::disk(config('filesystems.media_disk'))->delete($slide->path);

        $slide->delete();

        return redirect()->back();
    }
}
