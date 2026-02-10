<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdvisor
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'dosen') {
            return $next($request);
        }

        abort(403, 'Hanya dosen yang dapat mengakses fitur ini.');
    }
}
