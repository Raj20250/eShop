<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // User must be logged in AND role must be "client"
        if (Auth::check() && Auth::user()->role === 'client') {
            return $next($request);
        }

        // If not a client → send them back to login page
        return redirect()->route('client.login');
    }

}
