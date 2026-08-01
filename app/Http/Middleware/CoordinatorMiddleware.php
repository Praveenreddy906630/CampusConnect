<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'coordinator') {
            return redirect('/'); // or a 403 page
        }

        return $next($request);
    }
}
