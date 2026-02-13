<?php

namespace App\Http\Controllers;

use App\Http\EditorHtmlSanitizer;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('faqs.index', [
            'faqs' => Faq::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('faqs.create', [
            'faq' => new Faq,
        ]);
    }

    public function edit(Faq $faq)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('faqs.edit', [
            'faq' => $faq,
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

        Faq::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => $sanitizedBody,
            'order' => Faq::count() + 1,
        ]);

        return redirect()->route('faqs.index');
    }

    public function update(Faq $faq)
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

        $faq->update($data);

        return redirect()->route('faqs.index');
    }

    public function destroy(Faq $faq)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $faq->delete();

        return redirect()->back();
    }
}
