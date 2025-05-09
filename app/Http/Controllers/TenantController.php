<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tenant;
use App\Services\TenantService;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Tenancy;

class TenantController extends Controller
{
    protected $service;
    protected $relations = ['domains'];

    public function __construct(TenantService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll()->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function createTenant(Request $request)
    {
        Log::info('Iniciando creación de tenant', ['request' => $request->all()]);

        // Validación del request
        $request->validate([
            'tenant_name' => 'required|string|unique:tenants,id',
        ]);

        $tenantId = strtolower(str_replace(' ', '-', $request->tenant_name));
        $baseDomain = env('TENANT_BASE_DOMAIN', 'localhost'); 
        $domain = "{$tenantId}.{$baseDomain}";

        Log::debug('Datos generados', ['tenantId' => $tenantId, 'domain' => $domain]);

        try {
            // Creación del tenant
            $tenant = Tenant::create(['id' => $tenantId]);         
            $tenant->domains()->create(['domain' => $domain]);        

            Log::debug('Tenant y dominio creados', ['tenant_id' => $tenant->id, 'domain' => $domain]);

       
            tenancy()->initialize($tenant);

        
            try {
                Artisan::call('tenants:migrate');
                Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
                Log::debug('Migraciones y seeders ejecutados');
            } catch (\Exception $e) {
                Log::error('Error en migraciones o seeders', ['error' => $e->getMessage()]);
                return response()->json([
                    'message' => 'Error en migraciones o seeders',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'message' => 'Tenant creado exitosamente',
                'tenant_id' => $tenantId,
                'domain' => $domain
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al crear tenant', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al crear el tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
