<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'mahasiswa') {
            return $next($request);
        }

        abort(403, 'Hanya mahasiswa yang dapat mengakses fitur ini.');
    }
}
