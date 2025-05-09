<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Stancl\Tenancy\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DetectTenantAndService
{


    public function handle($request, Closure $next)
    {
   
        $tenantId = $request->header('X-Tenant-ID');

        // Usa el modelo Tenant, no DB::table()
        $tenant = Tenant::on('central')->find($tenantId);

        if (!$tenant) {
            abort(403, 'Tenant no existe');
        }

        // ... lógica del nombre de la DB ...
        tenancy()->initialize($tenant);

        return $next($request);
    }
}
