<?php

namespace Database\Seeders;

use App\Models\SocialSecurity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialSecuritiesSeeder extends Seeder
{
    public function run()
    {
        SocialSecurity::updateOrCreate([
            'type_scheme' => 'Contributivo',
            'affiliate_type' => 'Cotizante',
            'category' => 'Categoría A',
            'entity_id' => 1,
            'arl' => 'Sura',
            'afp' => 'Colpensiones',
            'insurer' => 'Aseguradora 1'
        ]);

        // Puedes agregar más registros si lo deseas
        SocialSecurity::updateOrCreate([
            'type_scheme' => 'Subsidiado',
            'affiliate_type' => 'Beneficiario',
            'category' => 'Nivel 1',
            'eps' => 'Compensar',
            'arl' => 'Bolivar',
            'afp' => 'Porvernir',
            'insurer' => 'Aseguradora 2'
        ]);
    }
}
