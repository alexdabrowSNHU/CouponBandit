<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        //
        $middleware->trustProxies(at: '*');

        // 2. Ensure cookies work on both Local (HTTP) and Live (HTTPS)
        // This prevents "Secure" cookie errors on your local dev environment.
        $middleware->statefulApi();

        $middleware->validateCsrfTokens(except: [
            'api/track/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()->route('login')->with('error', 'Your session expired. Please sign in again.');
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419) {
                return redirect()->route('login')->with('error', 'Your session expired. Please sign in again.');
            }
        });
    })->create();
