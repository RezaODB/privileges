<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    /**
     * @var list<string>
     */
    private const array AUDIO_MIMETYPES = ['audio/mpeg', 'audio/mp3', 'audio/mp4', 'audio/x-m4a'];

    /**
     * @var list<string>
     */
    private const array AUDIO_EXTENSIONS = ['mp3', 'm4a'];

    public function index(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('podcasts.index', [
            'podcasts' => Podcast::query()->orderBy('lang')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('podcasts.create', ['podcast' => new Podcast]);
    }

    public function edit(Podcast $podcast): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('podcasts.edit', ['podcast' => $podcast]);
    }

    public function store(): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['required', 'in:fr,en'],
            'title' => ['required', 'string', 'max:255'],
            'guest' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimetypes:'.implode(',', self::AUDIO_MIMETYPES), 'extensions:'.implode(',', self::AUDIO_EXTENSIONS)],
        ]);

        Podcast::query()->create([
            ...collect($data)->except('file')->all(),
            'path' => request()->file('file')->store('podcasts', config('filesystems.media_disk')),
            'order' => Podcast::query()->forLocale($data['lang'])->max('order') + 1,
        ]);

        return redirect()->route('podcasts.index');
    }

    public function update(Podcast $podcast): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'in:fr,en'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'guest' => ['sometimes', 'nullable', 'string', 'max:255'],
            'duration' => ['sometimes', 'nullable', 'string', 'max:255'],
            'order' => ['sometimes', 'required', 'integer'],
            'file' => ['sometimes', 'file', 'mimetypes:'.implode(',', self::AUDIO_MIMETYPES), 'extensions:'.implode(',', self::AUDIO_EXTENSIONS)],
        ]);

        if (request()->hasFile('file')) {
            $this->deleteUpload($podcast);
            $data['path'] = request()->file('file')->store('podcasts', config('filesystems.media_disk'));
        }

        unset($data['file']);

        $podcast->update($data);

        return redirect()->route('podcasts.index');
    }

    public function destroy(Podcast $podcast): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $this->deleteUpload($podcast);

        $podcast->delete();

        return redirect()->back();
    }

    /**
     * Remove the stored file, leaving the four originals at the public root
     * alone: they are not ours to delete.
     */
    private function deleteUpload(Podcast $podcast): void
    {
        if (str_contains($podcast->path, '/')) {
            Storage::disk(config('filesystems.media_disk'))->delete($podcast->path);
        }
    }
}
