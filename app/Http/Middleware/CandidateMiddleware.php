<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CandidateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // منطق الـ middleware هنا (مثال: التأكد أن المستخدم هو مرشح)
        if (auth()->check() && auth()->user()->user_type !== 'candidate') {
            return redirect('/'); 
        }

        return $next($request);
    }
}
