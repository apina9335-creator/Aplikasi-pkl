<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Cek jika user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Split roles by comma (handle multiple roles: check.role:admin,dosen)
        $allowedRoles = explode(',', $roles);
        $allowedRoles = array_map('trim', $allowedRoles);
        
        // Debug: Log the check
        \Log::info('CheckRole middleware', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'allowed_roles' => $allowedRoles,
            'route' => $request->path(),
        ]);
        
        // Cek jika user memiliki role yang diizinkan
        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        // Jika tidak memiliki akses
        abort(403, 'Unauthorized access.');
    }
}