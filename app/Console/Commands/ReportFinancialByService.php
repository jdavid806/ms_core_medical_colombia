<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportFinancialByService extends Command
{
    protected $signature = 'report:financial-services';
    protected $description = 'Analiza los costos y márgenes por servicio prestado usando datos del MS Admin';

    protected $urlBase = '';

    public function __construct()
    {
        parent::__construct(); // Es importante llamar al constructor de la clase padre.
        $this->urlBase = env('INVENTORY_SERVICE_URL', 'http://localhost:8001/api/v1/');
    }

    public function handle()
    {
        $this->info('📊 Generando análisis financiero...');

        $appointments = Appointment::with('assignedUserAvailability')
            ->whereNotNull('appointment_date')
            ->whereDate('appointment_date', '<=', now())
            ->whereNotNull('product_id')
            ->get();

        $grouped = $appointments->groupBy('product_id');

        $results = [];

        foreach ($grouped as $productId => $items) {
            $cantidad = $items->count();
            $tiempoPromedio = round($items->avg(fn ($appt) => optional($appt->assignedUserAvailability)->appointment_duration ?? 0));

            // Consulta al microservicio admin
            $productResponse = Http::get($this->urlBase . "products/{$productId}");

            if ($productResponse->failed()) {
                Log::warning("❗ No se pudo obtener el producto {$productId}");
                continue;
            }

            $product = $productResponse->json();

            $costo = $product['purchase_price'] ?? 0;
            $precio = $product['sale_price'] ?? 0;
            $nombre = $product['name'] ?? "Producto {$productId}";

            $costoPromedio = round($costo);
            $precioFacturado = $precio * $cantidad;
            $margen = $precioFacturado - ($costoPromedio * $cantidad);

            $results[] = [
                'servicio' => $nombre,
                'costo_promedio' => $costoPromedio,
                'precio_facturado' => $precioFacturado,
                'margen' => $margen,
                'tiempo_promedio_min' => $tiempoPromedio,
                'cantidad_realizadas' => $cantidad,
            ];
        }

        // Enviar al webhook
        $webhookUrl = config('services.webhooks.n8n-costo-rentabilidad');
        $response = Http::post($webhookUrl, $results);

        if ($response->successful()) {
            Log::info('✅ Webhook financiero enviado correctamente.', ['response' => $response->json()]);
            $this->info('✅ Webhook financiero enviado con éxito');
        } else {
            Log::error('❌ Error al enviar webhook financiero.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            $this->error('❌ Error al enviar webhook financiero');
        }
    }
}
