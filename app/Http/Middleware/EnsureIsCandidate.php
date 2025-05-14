<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsCandidate
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'candidate') {
            return $next($request);
        }

        return redirect('/')->with('error', 'not allow to access as a candidate');
    }
}