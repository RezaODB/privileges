<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PageController extends Controller
{
    public function dashboard()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('dashboard');
    }

    public function index()
    {
        return view('index');
    }
    
    public function policy()
    {
        return view('policy');
    }
    
    public function step1()
    {
        return view('step1');
    }

    public function step2()
    {
        return view('step2');
    }

    public function step3()
    {
        return view('step3');
    }

    public function step4()
    {
        return view('step4');
    }

    public function step5()
    {
        return view('step5');
    }
    
    public function step6()
    {
        return view('step6');
    }

}
