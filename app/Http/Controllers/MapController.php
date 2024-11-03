<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Map;
use Illuminate\Support\Facades\Gate;

class MapController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('maps.index', [
            'maps' => Map::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('maps.create', [
            'map' => new Map
        ]);
    }

    public function edit(Map $map)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('maps.edit', [
            'map' => $map
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

        Map::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => request('body'),
            'order' => Map::count() + 1
        ]);

        return redirect()->route('maps.index');
    }

    public function update(Map $map)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $map->update($data);

        return redirect()->route('maps.index');
    }

    public function destroy(Map $map)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $map->delete();

        return redirect()->back();
    }
}
