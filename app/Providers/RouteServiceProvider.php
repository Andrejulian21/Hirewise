<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\EnsureRole; // Asegúrate de importar el middleware

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        parent::boot();
        Route::aliasMiddleware('role', EnsureRole::class); // Aquí registramos el middleware de roles

        $this->routes(function () {
            // 🔹 Carga de rutas API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // 🔹 Carga de rutas WEB
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
