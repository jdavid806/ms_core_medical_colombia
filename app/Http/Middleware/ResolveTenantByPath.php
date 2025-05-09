<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant;
use Stancl\Tenancy\Facades\Tenancy;

class ResolveTenantByPath
{
    public function handle(Request $request, Closure $next): Response
    {
        $segments = explode('/', trim($request->path(), '/'));
        $tenantId = $segments[0] ?? null;

        if ($tenantId) {
            // Buscar el tenant en la base central
            $tenant = Tenant::where('id', $tenantId)->first();

            if ($tenant) {
                // Hacer que el sistema reconozca este tenant
                Tenancy::initialize($tenant);
            }
        }

        return $next($request);
    }
}
