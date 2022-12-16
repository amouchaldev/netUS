<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasNoCommunity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::check() ) {
            
        // }
        if (Auth::user()->communities->count() < 1) {
            // return ['key' => ''];
            // Auth::user()->communities->count();
            // die();
            return redirect()->route('communities')->with('message', 'Please you should Join at least one community to start your acitivity');
        }
            return $next($request);

    }
}
