<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
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
