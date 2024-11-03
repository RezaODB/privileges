<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('votes.index', [
            'votes' => Vote::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('votes.create', [
            'vote' => new Vote
        ]);
    }

    public function edit(Vote $vote)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('votes.edit', [
            'vote' => $vote
        ]);
    }

    public function store()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        request()->validate([
            'question_fr' => ['required', 'string'],
            'question_en' => ['nullable', 'string'],
        ]);

        Vote::create([
            'question_fr' => request('question_fr'),
            'question_en' => request('question_en'),
            'order' => Vote::count() + 1
        ]);

        return redirect()->route('votes.index');
    }

    public function update(Vote $vote)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'question_fr' => ['sometimes', 'required', 'string'],
            'question_en' => ['nullable', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $vote->update($data);

        return redirect()->route('votes.index');
    }

    public function destroy(Vote $vote)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $vote->delete();

        return back();
    }
}
