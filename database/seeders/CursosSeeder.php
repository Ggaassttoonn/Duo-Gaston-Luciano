<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cursos')->insert([

            [
                'ciclo' => '2024',
                'grado' => 'Primero',
                'seccion' => 'A',
                'turno' => 'Mañana'
            ],
            [
                'ciclo' => '2024',
                'grado' => 'Primero',
                'seccion' => 'B',
                'turno' => 'Tarde'
            ],
            [
                'ciclo' => '2024',
                'grado' => 'Segundo',
                'seccion' => 'A',
                'turno' => 'Mañana'
            ],
            [
                'ciclo' => '2024',
                'grado' => 'Segundo',
                'seccion' => 'B',
                'turno' => 'Tarde'
            ],
            [
                'ciclo' => '2024',
                'grado' => 'Tercero',
                'seccion' => 'A',
                'turno' => 'Mañana'
            ],
            [
                'ciclo' => '2024',
                'grado' => 'Tercero',
                'seccion' => 'B',
                'turno' => 'Tarde'
            ]

        ]);
    }

    public function down(): void
    {
        DB::table('cursos')->truncate();
    }
}
