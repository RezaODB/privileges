<?php

namespace App\Http\Controllers;

use App\Http\EditorHtmlSanitizer;
use App\Models\Theory;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TheoryController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('theories.index', [
            'theories' => Theory::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('theories.create', [
            'theory' => new Theory,
        ]);
    }

    public function edit(Theory $theory)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('theories.edit', [
            'theory' => $theory,
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

        Theory::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => $sanitizedBody,
            'order' => Theory::count() + 1,
        ]);

        return redirect()->route('theories.index');
    }

    public function update(Theory $theory)
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

        $theory->update($data);

        return redirect()->route('theories.index');
    }

    public function destroy(Theory $theory)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $theory->delete();

        return redirect()->back();
    }
}
