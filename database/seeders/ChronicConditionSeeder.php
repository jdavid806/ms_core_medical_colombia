<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChronicCondition;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChronicConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            // Enfermedades cardiovasculares
            ['cie11_code' => 'BA00', 'name' => 'Hipertensión esencial primaria'],
            ['cie11_code' => 'BA01', 'name' => 'Hipertensión secundaria'],
            ['cie11_code' => 'BA40', 'name' => 'Angina de pecho'],
            ['cie11_code' => 'BA41', 'name' => 'Infarto agudo de miocardio'],
            ['cie11_code' => 'BA42', 'name' => 'Infarto de miocardio subsecuente'],
            ['cie11_code' => 'BA43', 'name' => 'Otras enfermedades isquémicas agudas del corazón'],
            ['cie11_code' => 'BA44', 'name' => 'Enfermedad isquémica crónica del corazón'],
            ['cie11_code' => 'BA50', 'name' => 'Insuficiencia cardíaca congestiva'],
            ['cie11_code' => 'BA51', 'name' => 'Insuficiencia ventricular izquierda'],
            ['cie11_code' => 'BA52', 'name' => 'Insuficiencia cardíaca no especificada'],
            ['cie11_code' => 'BA60', 'name' => 'Fibrilación y aleteo auricular'],
            ['cie11_code' => 'BA61', 'name' => 'Taquicardia paroxística supraventricular'],
            ['cie11_code' => 'BA62', 'name' => 'Taquicardia ventricular'],
            ['cie11_code' => 'BA63', 'name' => 'Bradicardia'],
            ['cie11_code' => 'BA65', 'name' => 'Bloqueo auriculoventricular'],
            ['cie11_code' => 'BB00', 'name' => 'Hemorragia intracerebral'],
            ['cie11_code' => 'BB01', 'name' => 'Infarto cerebral'],

            // Enfermedades respiratorias crónicas
            ['cie11_code' => 'CA20', 'name' => 'Bronquitis crónica simple'],
            ['cie11_code' => 'CA21', 'name' => 'Bronquitis crónica mucopurulenta'],
            ['cie11_code' => 'CA22', 'name' => 'Enfisema'],
            ['cie11_code' => 'CA23', 'name' => 'Otra enfermedad pulmonar obstructiva crónica'],
            ['cie11_code' => 'CA40', 'name' => 'Asma predominantemente alérgica'],
            ['cie11_code' => 'CA41', 'name' => 'Asma no alérgica'],
            ['cie11_code' => 'CA42', 'name' => 'Asma de aparición tardía'],
            ['cie11_code' => 'CA43', 'name' => 'Estado asmático'],

            // Diabetes y trastornos endocrinos
            ['cie11_code' => '5A10', 'name' => 'Diabetes mellitus tipo 1'],
            ['cie11_code' => '5A11', 'name' => 'Diabetes mellitus tipo 2'],
            ['cie11_code' => '5A12', 'name' => 'Diabetes mellitus relacionada con la desnutrición'],
            ['cie11_code' => '5A13', 'name' => 'Otros tipos específicos de diabetes mellitus'],
            ['cie11_code' => '5A14', 'name' => 'Diabetes mellitus no especificada'],
            ['cie11_code' => '5A20', 'name' => 'Obesidad debida a exceso de calorías'],
            ['cie11_code' => '5A21', 'name' => 'Obesidad inducida por fármacos'],
            ['cie11_code' => '5A22', 'name' => 'Obesidad con hipoventilación alveolar'],
            ['cie11_code' => '5A70', 'name' => 'Hipotiroidismo congénito'],
            ['cie11_code' => '5A71', 'name' => 'Hipotiroidismo por deficiencia de yodo'],
            ['cie11_code' => '5A72', 'name' => 'Hipotiroidismo por medicamentos y otras sustancias exógenas'],
            ['cie11_code' => '5A73', 'name' => 'Hipotiroidismo postprocedimiento'],

            // Enfermedades renales
            ['cie11_code' => '5B50', 'name' => 'Enfermedad renal crónica, estadio 1'],
            ['cie11_code' => '5B51', 'name' => 'Enfermedad renal crónica, estadio 2'],
            ['cie11_code' => '5B52', 'name' => 'Enfermedad renal crónica, estadio 3'],
            ['cie11_code' => '5B53', 'name' => 'Enfermedad renal crónica, estadio 4'],
            ['cie11_code' => '5B54', 'name' => 'Enfermedad renal crónica, estadio 5'],
            ['cie11_code' => '5B55', 'name' => 'Enfermedad renal crónica, estadio no especificado'],
            ['cie11_code' => '5B83', 'name' => 'Cálculo del riñón y del uréter'],

            // Puedes seguir el mismo patrón para los demás grupos...
        ];

        foreach ($conditions as $condition) {
            ChronicCondition::updateOrCreate($condition);
        }
    }
}
