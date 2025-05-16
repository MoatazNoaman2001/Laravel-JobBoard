<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated and is an admin
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return $next($request);
        }

        // If user is authenticated but not an admin, redirect to dashboard with error
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('error', 'You do not have admin access.');
        }

        // If user is not authenticated, redirect to login
        return redirect()->route('login')->with('error', 'Please login to access this page.');
    }
}
