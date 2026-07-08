<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materias')->insert([
            ['nombre' => 'Lengua',                                          'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Matemática',                                      'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Ciencias Sociales',                               'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Ciencias Naturales',                              'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Formación Ética y Ciudadana',                     'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Educación Física',                                'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Educación Tecnológica (Tecnología)',              'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Educación Artística',                             'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Música',                                          'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Artes Visuales / Plástica',                       'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Teatro',                                          'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Danza',                                           'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Lengua Extranjera (Inglés)',                      'area_id' => null, 'primer_ciclo' => false, 'segundo_ciclo' => true,  'tercer_ciclo' => true],
            ['nombre' => 'Educación Intercultural Bilingüe',                'area_id' => null, 'primer_ciclo' => true,  'segundo_ciclo' => true,  'tercer_ciclo' => true],
        ]);
    }

    public function down(): void
    {
        DB::table('materias')->truncate();
    }
}
