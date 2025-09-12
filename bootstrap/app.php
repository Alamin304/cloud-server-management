<?php

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;




return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->appendToGroup('api', [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    })->create();


// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         api: __DIR__.'/../routes/api.php',
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware): void {
//         // Add Sanctum + throttle to API group
//         $middleware->appendToGroup('api', [
//             \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
//             'throttle:api',
//             \Illuminate\Routing\Middleware\SubstituteBindings::class,
//         ]);

//         // Define rate limiter here
//         RateLimiter::for('api', function ($request) {
//             return Limit::perMinute(60)->by(
//                 optional($request->user())->id ?: $request->ip()
//             );
//         });
//     })
//     ->withExceptions(function (Exceptions $exceptions): void {
//         //
//     })
//     ->create();
