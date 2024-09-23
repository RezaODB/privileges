<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brochure;
use Illuminate\Support\Facades\Gate;

class BrochureController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('brochures.index', [
            'brochures' => Brochure::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('brochures.create', [
            'brochure' => new Brochure
        ]);
    }

    public function edit(Brochure $brochure)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('brochures.edit', [
            'brochure' => $brochure
        ]);
    }

    public function store()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        request()->validate([
            'lang' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        Brochure::create([
            'lang' => request('lang'),
            'category' => request('category'),
            'title' => request('title'),
            'body' => request('body'),
            'order' => Brochure::count()
        ]);

        return redirect()->route('brochures.index');
    }

    public function update(Brochure $brochure)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $brochure->update($data);

        return redirect()->route('brochures.index');
    }

    public function destroy(Brochure $brochure)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $brochure->delete();

        return redirect()->back();
    }
}
