<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quota;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('users.index', [
            'users' => User::where('role', 1)->get(),
            'total' => Quota::count()
        ]);
    }
}
