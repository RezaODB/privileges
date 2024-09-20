<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->query('lang')) {
            session(['lang' => request()->query('lang')]);
        }

        $locale = session('lang', 'fr');

        app()->setLocale($locale);
        
        return $next($request);
    }
}
