<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Map;
use App\Models\User;
use App\Models\Intro;
use App\Models\Photo;
use App\Models\Theory;
use App\Models\Brochure;
use App\Models\Sculpture;
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
        return view('faq', [
            'faqs' => Faq::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function instructions()
    {
        return view('instructions');
    }
    
    public function step1()
    {
        return view('step', [
            'items' => Theory::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function step2()
    {
        return view('step', [
            'items' => Intro::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function step3()
    {
        return view('step', [
            'items' => Brochure::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function step4()
    {
        return view('step', [
            'items' => Photo::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function step5()
    {
        return view('step', [
            'items' => Map::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }
    
    public function step6()
    {
        return view('step', [
            'items' => Sculpture::orderBy('order')->where('lang', app()->getLocale())->get()
        ]);
    }

    public function upload()
    {
        $fileName = request()->file('file')->getClientOriginalName();
        $path = request()->file('file')->storeAs('uploads', $fileName, 'public');
        
        return response()->json(['location'=>"/storage/$path"]); 
    }

}
