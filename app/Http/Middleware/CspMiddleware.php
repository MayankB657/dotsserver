<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('Content-Security-Policy', "default-src 'self' http https: data: 'unsafe-inline' 'unsafe-eval'; worker-src 'self' blob:; media-src 'self' blob: data: https:; connect-src 'self' http://localhost:3000 ws://localhost:3000 https://dev-ubt-app04.dev.orientdots.net/node https://node.sizaf.com wss://node.sizaf.com wss://dev-ubt-app04.dev.orientdots.net/node; frame-ancestors 'self' https://dev-ubt-app06.dev.orientdots.net;");

        return $response;
    }
}
