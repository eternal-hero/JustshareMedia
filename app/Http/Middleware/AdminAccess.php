<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed |
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Settings
        $message = 'Forbidden';

        // Ensure user is logged in and user is Admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, $message);
        }

        // Handle request
        return $next($request);
    }
}
