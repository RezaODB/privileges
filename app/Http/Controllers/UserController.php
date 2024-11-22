<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Quota;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('users.index', [
            'users' => User::orderBy('order')->where('role', 1)->get(),
            'quotas' => Quota::count(),
            'votes' => Vote::count()
        ]);
    }

    public function show(User $user)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('users.show', [
            'user' => $user,
            'quotas' => Quota::count(),
            'votes' => Vote::count()
        ]);
    }

    public function destroy(User $user)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $user->delete();

        return back();
    }
}
