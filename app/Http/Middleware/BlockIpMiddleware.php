<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BlockIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Get the currently authenticated user's ID...
        $user = auth()->user();

         if (!empty($user) && $user->status == 0) {
            abort(403, "You are account is deactivated to access the site.");
        }
        
        return $next($request);
    }
}
