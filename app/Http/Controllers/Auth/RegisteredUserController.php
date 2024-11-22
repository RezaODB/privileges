<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'sex' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'policy' => ['required', 'accepted']
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'birthplace' => 'NA',
            'zip' => $request->zip,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'sex' => $request->sex,
            'role' => $request->email === 'info@flechette.be' ? 2 : 1,
            'order' => User::count(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user->answers()->create([
            'answers' => [],
            'votes' => []
        ]);

        if ($user->role === 1) {
            return redirect(route('index'));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
