<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\EnsureRole;

return Application::configure(basePath: __DIR__ . '/../')

    // 1) REGISTRO DE MIDDLEWARES (antes o al menos no después de cachear nada)
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ensure.role' => EnsureRole::class,
            // puedes dejar también los de Spatie, no molestan
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
