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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role
        $user = Auth::user();

        // Option 1: Using 'role' column (recommended)
        if (!isset($user->role) || $user->role !== 'admin') {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        // Option 2: Using 'is_admin' boolean
        // if (!isset($user->is_admin) || !$user->is_admin) {
        //     abort(403, 'Unauthorized access.');
        // }

        return $next($request);
    }
}
