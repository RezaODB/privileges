<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Figure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class FigureController extends Controller
{
    public function index(Chapter $chapter): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('figures.index', [
            'chapter' => $chapter,
            'figures' => $chapter->figures()->ordered()->get(),
        ]);
    }

    public function create(Chapter $chapter): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('figures.create', [
            'chapter' => $chapter,
            'figure' => new Figure,
        ]);
    }

    public function edit(Figure $figure): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('figures.edit', [
            'chapter' => $figure->chapter,
            'figure' => $figure,
        ]);
    }

    public function store(Chapter $chapter): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'value_fr' => ['required', 'string', 'max:255'],
            'value_en' => ['nullable', 'string', 'max:255'],
            'label_fr' => ['required', 'string'],
            'label_en' => ['nullable', 'string'],
        ]);

        $chapter->figures()->create([
            ...$data,
            'order' => $chapter->figures()->max('order') + 1,
        ]);

        return redirect()->route('chapters.figures.index', $chapter);
    }

    public function update(Figure $figure): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = request()->validate([
            'value_fr' => ['sometimes', 'required', 'string', 'max:255'],
            'value_en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'label_fr' => ['sometimes', 'required', 'string'],
            'label_en' => ['sometimes', 'nullable', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $figure->update($data);

        return redirect()->route('chapters.figures.index', $figure->chapter);
    }

    public function destroy(Figure $figure): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $figure->delete();

        return redirect()->back();
    }
}
