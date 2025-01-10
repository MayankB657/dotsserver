<?php

use App\Http\Middleware\CspMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\FileSharingPasswordCheck;
use Illuminate\Http\Request;
use App\Exceptions\InvalidOrderException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(CspMiddleware::class);
        $middleware->validateCsrfTokens(except: [
            'registerfacedata',
            'logout'
        ]);
        $middleware->alias([
            'blockIP' => \App\Http\Middleware\BlockIpMiddleware::class,
            'filesharingpassword' => FileSharingPasswordCheck::class,
            'Socialite' => \Laravel\Socialite\Facades\Socialite::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InvalidOrderException $e, Request $request) {
            return response()->view('errors.404', status: 404);
        });
    })->create();
?>
