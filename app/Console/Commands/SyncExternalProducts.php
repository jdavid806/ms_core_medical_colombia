<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\ExternalProductCache;
use Illuminate\Support\Facades\Http;

class SyncExternalProducts extends Command
{
    protected $signature = 'sync:external-products';
    protected $description = 'Sync product prices from external microservice';

    public function handle()
    {
        $url = config('services.admin.products_url');
        $this->info("Fetching products from $url...");

        $response = Http::get($url);
        if (! $response->ok()) {
            $this->error("Error fetching products: " . $response->status());
            return Command::FAILURE;
        }

        $products = $response->json();
        if (!isset($products['data']) || !is_array($products['data'])) {
            $this->error("Formato de respuesta incorrecto. No se encontraron productos.");
            return Command::FAILURE;
        }

        // 🔥 Aquí inicializamos la conexión correcta del tenant manualmente
        $tenant = Tenant::where('id', 'saluddev')->first(); // Cambia el criterio según sea necesario
        //dd($tenant);
        tenancy()->initialize($tenant);

        $this->info("Conexión actual después del cambio: " . config('database.default'));
        $this->info("Base de datos activa: " . DB::connection()->getDatabaseName());

        foreach ($products['data'] as $product) {
            ExternalProductCache::updateOrCreate(
                ['external_id' => $product['id']],
                [
                    'name' => $product['attributes']['name'] ?? 'N/A',
                    'purchase_price' => $product['attributes']['purchase_price'] ?? 0,
                    'sale_price' => $product['attributes']['sale_price'] ?? 0,
                ]
            );
        }

        $this->info("Sync completed. Total products: " . count($products['data']));
        return Command::SUCCESS;
    }
}
