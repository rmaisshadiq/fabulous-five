<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(function (Throwable $e, $request) {
        //     // Log the error for debugging
        //     Log::error('Application Error: ' . $e->getMessage(), [
        //         'exception' => $e,
        //         'url' => $request->fullUrl(),
        //         'user_id' => Auth::id() ?? 'guest'
        //     ]);
            
        //     // Don't redirect for API requests - return JSON instead
        //     if ($request->expectsJson()) {
        //         return response()->json([
        //             'error' => 'Something went wrong. Please try again later.'
        //         ], 500);
        //     }
            
        //     // Redirect to general error page for web requests
        //     return redirect()->route('error.general')->with('error', 'Something went wrong. Please try again later.');
        // });
    })->create();
