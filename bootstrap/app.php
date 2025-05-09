<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\ApiHeaderMiddleware;
use App\Http\Middleware\ResolveTenantByPath;
use App\Http\Middleware\DetectTenantAndService;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            $centralDomains = config('tenancy.central_domains');

            // Mantén las rutas API existentes sin prefijo
            Route::middleware('api')
                ->prefix('api') // Las rutas existentes mantienen su configuración
                ->group(base_path('routes/api.php'));

            // Rutas nuevas con prefijo de versión
            Route::middleware('api')
                ->prefix('api/v2') // Prefijo para la nueva versión
                ->group(base_path('routes/api_v2.php'));

            // Mantén las rutas existentes para los dominios centrales
            foreach ($centralDomains as $domain) {
                Route::middleware('api')
                    ->domain($domain)
                    ->prefix('api') // Sin cambios para rutas existentes
                    ->group(base_path('routes/api.php'));
            }

            // Rutas nuevas con prefijo de versión para los dominios centrales
            foreach ($centralDomains as $domain) {
                Route::middleware('api')
                    ->domain($domain)
                    ->prefix('api/v2') // Prefijo para la nueva versión
                    ->group(base_path('routes/api_v2.php'));
            }

            // Mantén las rutas existentes para tenants
            Route::middleware('api')
                ->group(base_path('routes/tenant.php'));

            // Rutas nuevas con prefijo de versión para tenants
            Route::middleware('api')
                ->prefix('medical') // Prefijo solo para las nuevas
                ->group(base_path('routes/tenant_v2.php'));
        }
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(DetectTenantAndService::class);
        $middleware->append(ApiHeaderMiddleware::class);
        $middleware->append(ResolveTenantByPath::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
