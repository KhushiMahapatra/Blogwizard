<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedUserIds = [1, 2, 3]; // Allowed user IDs

        if (Auth::check() && in_array(Auth::id(), $allowedUserIds)) {
            return $next($request); // Allow access
        }

        // Redirect unauthorized users to home with a flash message
        return redirect('/')->with('error', 'Unauthorized access to the dashboard.');
    }
}
