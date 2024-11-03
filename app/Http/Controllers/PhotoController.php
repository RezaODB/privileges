<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Support\Facades\Gate;

class PhotoController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('photos.index', [
            'photos' => Photo::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('photos.create', [
            'photo' => new Photo
        ]);
    }

    public function edit(Photo $photo)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('photos.edit', [
            'photo' => $photo
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

        Photo::create([
            'lang' => request('lang'),
            'title' => request('title'),
            'body' => request('body'),
            'order' => Photo::count() + 1
        ]);

        return redirect()->route('photos.index');
    }

    public function update(Photo $photo)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'lang' => ['sometimes', 'required', 'string', 'max:255'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $photo->update($data);

        return redirect()->route('photos.index');
    }

    public function destroy(Photo $photo)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $photo->delete();

        return redirect()->back();
    }
}
