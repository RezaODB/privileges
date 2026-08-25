<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    public function index(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sections.index', [
            'sections' => Section::query()->ordered()->withCount(['chapters', 'films'])->get(),
        ]);
    }

    public function create(): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sections.create', [
            'section' => new Section,
        ]);
    }

    public function edit(Section $section): View
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('sections.edit', [
            'section' => $section,
        ]);
    }

    public function store(): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        request()->merge([
            'slug' => Str::slug(request('slug') ?: request('title_fr', '')),
        ]);

        $data = request()->validate([
            'title_fr' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('sections', 'slug')],
            'published' => ['required', 'boolean'],
            'shows_quota' => ['required', 'boolean'],
        ]);

        Section::create([
            ...$data,
            'order' => Section::max('order') + 1,
        ]);

        return redirect()->route('sections.index');
    }

    public function update(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        if (request()->has('slug')) {
            request()->merge([
                'slug' => Str::slug((string) request('slug')),
            ]);
        }

        $data = request()->validate([
            'title_fr' => ['sometimes', 'required', 'string', 'max:255'],
            'title_en' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'alpha_dash', Rule::unique('sections', 'slug')->ignore($section)],
            'order' => ['sometimes', 'required', 'integer'],
            'published' => ['sometimes', 'required', 'boolean'],
            'shows_quota' => ['sometimes', 'required', 'boolean'],
        ]);

        $section->update($data);

        return redirect()->route('sections.index');
    }

    public function destroy(Section $section): RedirectResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $section->delete();

        return redirect()->back();
    }
}
