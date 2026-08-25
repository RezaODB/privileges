<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('documents.index', [
            'documents' => Document::query()->orderBy('lang')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('documents.create', [
            'document' => new Document,
        ]);
    }

    public function edit(Document $document): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('documents.edit', [
            'document' => $document,
        ]);
    }

    public function store(): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimetypes:application/pdf', 'extensions:pdf'],
        ]);

        Document::create([
            'lang' => $data['lang'],
            'label' => $data['label'],
            'path' => request()->file('file')->store('documents', config('filesystems.media_disk')),
            'order' => Document::max('order') + 1,
        ]);

        return redirect()->route('documents.index');
    }

    public function update(Document $document): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'label' => ['sometimes', 'required', 'string', 'max:255'],
            'order' => ['sometimes', 'required', 'integer'],
            'file' => ['sometimes', 'file', 'mimetypes:application/pdf', 'extensions:pdf'],
        ]);

        if (request()->hasFile('file')) {
            Storage::disk(config('filesystems.media_disk'))->delete($document->path);
            $data['path'] = request()->file('file')->store('documents', config('filesystems.media_disk'));
        }

        unset($data['file']);

        $document->update($data);

        return redirect()->route('documents.index');
    }

    public function destroy(Document $document): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        Storage::disk(config('filesystems.media_disk'))->delete($document->path);

        $document->delete();

        return redirect()->back();
    }

    public function download(Document $document): StreamedResponse
    {
        abort_unless(
            Storage::disk(config('filesystems.media_disk'))->exists($document->path),
            404
        );

        return Storage::disk(config('filesystems.media_disk'))
            ->download($document->path, $document->downloadName());
    }
}
