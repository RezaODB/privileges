<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Intro;
use Illuminate\Support\Facades\Gate;

class IntroController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('intros.index', [
            'intros' => Intro::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('intros.create', [
            'intro' => new Intro
        ]);
    }

    public function edit(Intro $intro)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('intros.edit', [
            'intro' => $intro
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

        Intro::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => request('body'),
            'order' => Intro::count() + 1
        ]);

        return redirect()->route('intros.index');
    }

    public function update(Intro $intro)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $intro->update($data);

        return redirect()->route('intros.index');
    }

    public function destroy(Intro $intro)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $intro->delete();

        return redirect()->back();
    }
}
