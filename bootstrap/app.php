<?php

use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsGuest;
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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(
            [
                'guest' => UserIsGuest::class,
                'admin' => UserIsAdmin::class
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
