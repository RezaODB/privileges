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
    
    public function theory()
    {
        return view('theory');
    }
    
    public function info()
    {
        return view('info');
    }
    
    public function stats()
    {
        return view('stats');
    }
    
    public function id()
    {
        return view('id');
    }
    
    public function quotas()
    {
        return view('quotas');
    }
    
    public function brochure()
    {
        return view('brochure');
    }
    
    public function vote()
    {
        return view('vote');
    }

}
