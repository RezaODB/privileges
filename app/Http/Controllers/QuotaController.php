<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quota;
use Illuminate\Support\Facades\Gate;

class QuotaController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('quotas.index', [
            'quotas' => Quota::orderBy('order')->get()
        ]);
    }

    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('quotas.create', [
            'quota' => new Quota
        ]);
    }

    public function edit(Quota $quota)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('quotas.edit', [
            'quota' => $quota
        ]);
    }

    public function store()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        request()->validate([
            'question_fr' => ['required', 'string'],
            'question_en' => ['nullable', 'string'],
        ]);

        Quota::create([
            'question_fr' => request('question_fr'),
            'question_en' => request('question_en'),
            'order' => Quota::count()
        ]);

        return redirect()->route('quotas.index');
    }

    public function update(Quota $quota)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $data = request()->validate([
            'question_fr' => ['sometimes', 'required', 'string'],
            'question_en' => ['sometimes', 'required', 'string'],
            'order' => ['sometimes', 'required', 'integer'],
        ]);

        $quota->update($data);

        return redirect()->route('quotas.index');
    }

    public function destroy(Quota $quota)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        $quota->delete();

        return redirect()->back();
    }
}