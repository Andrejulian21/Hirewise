<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\EnsureRole;
use App\Http\Middleware\EnsureHasCompany;

return Application::configure(basePath: __DIR__ . '/../')

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ensure.role' => EnsureRole::class,
            'has.company' => EnsureHasCompany::class,
        ]);
    })

    // 2) RUTAS
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
