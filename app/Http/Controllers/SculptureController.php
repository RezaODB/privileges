<?php

namespace App\Http\Controllers;

use App\Http\EditorHtmlSanitizer;
use App\Models\Sculpture;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class SculptureController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sculptures.index', [
            'sculptures' => Sculpture::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sculptures.create', [
            'sculpture' => new Sculpture,
        ]);
    }

    public function edit(Sculpture $sculpture)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sculptures.edit', [
            'sculpture' => $sculpture,
        ]);
    }

    public function store()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $sanitizedBody = app(EditorHtmlSanitizer::class)->sanitize((string) request('body'));

        Sculpture::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => $sanitizedBody,
            'order' => Sculpture::count() + 1,
        ]);

        return redirect()->route('sculptures.index');
    }

    public function update(Sculpture $sculpture)
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

        $sculpture->update($data);

        return redirect()->route('sculptures.index');
    }

    public function destroy(Sculpture $sculpture)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $sculpture->delete();

        return redirect()->back();
    }
}
