<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Theory;
use App\Models\Brochure;
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

    public function faq()
    {
        return view('faq');
    }

    public function instructions()
    {
        return view('instructions');
    }
    
    public function step1()
    {
        return view('step1', [
            'theories' => Theory::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function step2()
    {
        return view('step2');
    }

    public function step3()
    {
        return view('step3', [
            'brochures' => Brochure::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
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

    public function upload()
    {
        $fileName = request()->file('file')->getClientOriginalName();
        $path = request()->file('file')->storeAs('uploads', $fileName, 'public');
        
        return response()->json(['location'=>"/storage/$path"]); 
    }

}
